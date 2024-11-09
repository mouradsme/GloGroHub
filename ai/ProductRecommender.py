import pandas as pd
import tensorflow as tf
from sklearn.preprocessing import StandardScaler, LabelEncoder
from sklearn.model_selection import train_test_split
import numpy as np

class ProductRecommender:
    target_columns = ['product_id', 'category_id',  'supplier_id', 'price', 'ai_demand_score', 'cultural_relevance_score', 'target_column']

    def __init__(self, product_data):
        # Initialize the product data
        self.product_data = product_data
        
        # Initialize models and preprocessors
        self.scaler = StandardScaler()
        self.label_encoder = LabelEncoder()
        self.model = None
        
    def preprocess_data(self):
        """
        Preprocesses the product data for training.
        - Encodes categorical variables.
        - Scales numerical features.
        """
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
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
        
        # Train the model
        self.model.fit(X_train, y_train, epochs=10, batch_size=32, validation_data=(X_test, y_test))
    
    def recommend_products(self, product_id, top_n=5):
        """
        Recommends products based on the trained model.
        - Predicts scores for each product and returns the top_n most similar products.
        """
        if self.model is None:
            raise ValueError("Model has not been trained yet.")
        
        # Features to be used for recommendations
        columns = ['product_id', 'category_id', 'supplier_id', 'price', 'ai_demand_score', 'cultural_relevance_score']
        
        # Get the features for the given product_id
        product = self.product_data[self.product_data['product_id'] == product_id].iloc[0]
        product_features = product[columns].values.reshape(1, -1)  # Reshape for prediction
        
        # Get predictions for all products
        product_scores = []
        for _, prod in self.product_data.iterrows():
            prod_features = prod[columns].values.reshape(1, -1)  # Features for this product
            score = self.model.predict(prod_features)  # Predict score for this product
            product_scores.append((prod['product_id'], score[0][0]))
        
        # Sort products by predicted score
        product_scores.sort(key=lambda x: x[1], reverse=True)
        
        # Return top_n products
        recommended_products = [score[0] for score in product_scores[:top_n]]
        return recommended_products
    
    def predict_and_recommend(self, product_id, top_n=5):
        """
        A full cycle: Preprocess, build, train, and recommend products.
        """
        # Preprocess data
        self.preprocess_data()
        
        # Build the model
        self.build_model()
        
        # Train the model
        self.train_model()
        
        # Get product recommendations
        recommendations = self.recommend_products(product_id, top_n)
        return recommendations

# Example usage
product_data = pd.DataFrame({
    'product_id': [1, 2, 3, 4, 5],
    'name': ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
    'category_id': ['A', 'B', 'A', 'C', 'B'],
    'supplier_id': ['S1', 'S2', 'S1', 'S3', 'S2'],
    'price': [100, 200, 150, 300, 250],
    'ai_demand_score': [0.9, 0.8, 0.85, 0.6, 0.95],
    'cultural_relevance_score': [0.7, 0.8, 0.75, 0.6, 0.9]
})

recommender = ProductRecommender(product_data)
recommended_products = recommender.predict_and_recommend(product_id=1, top_n=3)
print(f"Recommended Products: {recommended_products}")
