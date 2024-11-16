import mysql.connector
import pandas as pd
import tensorflow as tf
from sklearn.preprocessing import StandardScaler, LabelEncoder
from sklearn.model_selection import train_test_split
from sklearn.metrics.pairwise import cosine_similarity

import numpy as np
import random 

class ProductRecommender:
    target_columns = ['product_id', 'category_id', 'supplier_id', 'price', 'ai_demand_score', 'cultural_relevance_score', 'target_column']

    def __init__(self, db_config):
        # Initialize the MySQL database connection
        self.db_config = db_config
        self.product_data = None  # This will hold the product data
        
        # Initialize models and preprocessors
        self.scaler = StandardScaler()
        self.label_encoder = LabelEncoder()
        self.model = None
        
        # Set the random seeds for reproducibility
        self.set_random_seed(42)

    def set_random_seed(self, seed):
        """
        Set the random seed for reproducibility across different libraries.
        """
        random.seed(seed)
        np.random.seed(seed)
        tf.random.set_seed(seed)

    def load_data_from_mysql(self):
        """
        Loads product data from MySQL database.
        """
        # Connect to the MySQL database
        connection = mysql.connector.connect(
            host=self.db_config['host'],
            user=self.db_config['user'],
            password=self.db_config['password'],
            database=self.db_config['database']
        )
        
        # SQL query to fetch the product data
        query = "SELECT id as product_id, category_id, supplier_id, price, ai_demand_score, cultural_relevance_score, name FROM products"
        
        # Fetch data into a pandas DataFrame
        self.product_data = pd.read_sql(query, connection)
        
        # Close the database connection
        connection.close()

    def preprocess_data(self):
        """
        Preprocesses the product data for training.
        - Encodes categorical variables.
        - Scales numerical features.
        """
        if self.product_data is None:
            raise ValueError("Product data is not loaded. Please load data first.")

        # Encoding categorical variables (e.g., 'category_id', 'supplier_id', etc.)
        self.product_data['category_id'] = self.label_encoder.fit_transform(self.product_data['category_id'])
        self.product_data['supplier_id'] = self.label_encoder.fit_transform(self.product_data['supplier_id'])
        
        # Drop the 'name' column and any other non-numeric columns
        self.product_data = self.product_data.drop(columns=['name'])  # Exclude non-numeric columns

        # Scaling the numerical columns (price, demand score, etc.)
        numerical_columns = ['price', 'ai_demand_score', 'cultural_relevance_score']
        self.product_data[numerical_columns] = self.scaler.fit_transform(self.product_data[numerical_columns])
        
        # Ensure 'target_column' is included
        self.product_data['target_column'] = np.random.choice([0, 1], size=len(self.product_data))  # Example binary target column
        
        # Return the preprocessed data
        return self.product_data
    
    def build_model(self):
        """
        Builds the TensorFlow recommender model.
        """
        model = tf.keras.Sequential([
            tf.keras.layers.Input(shape=(6,)),  # Adjusted input layer to match 6 features
            tf.keras.layers.Dense(64, activation='relu'),
            tf.keras.layers.Dense(32, activation='relu'),
            tf.keras.layers.Dense(1)  # Output layer for binary classification (adjust if necessary)
        ])

        model.compile(optimizer='adam', loss='binary_crossentropy', metrics=['accuracy'])
        self.model = model
    
    def train_model(self):
        """
        Trains the model on the preprocessed product data.
        """
        if self.model is None:
            raise ValueError("Model has not been built yet.")
        
        # Separate features (X) and target (y)
        X = self.product_data.drop(columns=['target_column'])  # Drop 'target_column' from features
        y = self.product_data['target_column']  # Use 'target_column' as the target
        
        # Split data into training and testing sets
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)  # Fix shuffle with a random_state
        
        # Train the model
        self.model.fit(X_train, y_train, epochs=10, batch_size=32, validation_data=(X_test, y_test), verbose=0)
    

    def recommend_products(self, product_id, top_n=5):
        """
        Recommends products based on cosine similarity of features.
        """
        if self.product_data is None:
            raise ValueError("Product data is not loaded. Please load data first.")
        
        # Get the features for the given product_id
        columns = ['category_id', 'supplier_id', 'price', 'ai_demand_score', 'cultural_relevance_score']
        product = self.product_data[self.product_data['product_id'] == product_id].iloc[0]
        product_features = product[columns].values.reshape(1, -1)  # Reshape for similarity calculation
        
        # Compute cosine similarity between the product and all others
        product_scores = []
        for _, prod in self.product_data.iterrows():
            prod_features = prod[columns].values.reshape(1, -1)  # Features for this product
            similarity_score = cosine_similarity(product_features, prod_features)[0][0]
            product_scores.append((prod['product_id'], similarity_score))
        
        # Sort products by similarity score (highest first)
        product_scores.sort(key=lambda x: x[1], reverse=True)
        
        # Return top_n products
        recommended_products = [score[0] for score in product_scores[1:top_n+1]]  # Exclude the product itself
        return recommended_products
    
    def predict_and_recommend(self, product_id, top_n=5):
        """
        A full cycle: Preprocess, build, train, and recommend products.
        """
        # Load data from MySQL
        self.load_data_from_mysql()
        
        # Preprocess data
        self.preprocess_data()
        
        # Build the model
        self.build_model()
        
        # Train the 
        self.train_model()
        
        # Get product recommendations
        recommendations = self.recommend_products(product_id, top_n)
        return recommendations
