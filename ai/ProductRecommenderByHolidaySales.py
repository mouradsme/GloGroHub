import pandas as pd
import numpy as np
import mysql.connector
from sklearn.preprocessing import StandardScaler
from sklearn.metrics.pairwise import cosine_similarity

class ProductRecommenderByHolidaySales:
    def __init__(self, db_config):
        # Initialize database connection
        self.connection = mysql.connector.connect(**db_config)
        self.orders_data = None
        self.products_data = None
        self.holidays_data = None
        self.merged_data = None
        self.recommended_products = None

    def load_data(self):
        # Load Orders data
        orders_query = '''
        SELECT o.product_id, o.quantity, o.total_price, o.ordered_at
        FROM Orders o
        WHERE o.status = 'completed'
        '''
        self.orders_data = pd.read_sql(orders_query, self.connection)

        # Load Products data
        products_query = '''
        SELECT id, name, category_id, ethnic_culture, seasonal_demand, price, discounted_price
        FROM products
        WHERE status = 'active'
        '''
        self.products_data = pd.read_sql(products_query, self.connection)

        # Load Holidays data
        holidays_query = '''
        SELECT id, name, start_date, end_date, category_id
        FROM holidays
        WHERE status = 'active'
        '''
        self.holidays_data = pd.read_sql(holidays_query, self.connection)

    def merge_data(self):
        # Merge Orders with Products data
        merged_data = pd.merge(self.orders_data, self.products_data, left_on="product_id", right_on="id", how="inner")
        merged_data['ordered_at'] = pd.to_datetime(merged_data['ordered_at'])

        # Merge Holidays with Products data
        merged_data = pd.merge(merged_data, self.holidays_data, left_on='ordered_at', right_on='start_date', how='left')

        # Calculate Proximity to Holiday
        merged_data['proximity_to_holiday'] = pd.to_datetime(merged_data['ordered_at']) - pd.to_datetime(merged_data['start_date'])
        merged_data['is_near_holiday'] = merged_data['proximity_to_holiday'].apply(lambda x: abs(x.days) <= 7)

        self.merged_data = merged_data

    def recommend_by_holiday_sales(self):
        # Filter products ordered near holidays
        near_holiday_data = self.merged_data[self.merged_data['is_near_holiday']]

        # Check if we have any near holiday data
        if near_holiday_data.empty:
            print("No orders near holiday, recommending most sold products generally.")
            self.recommend_most_sold()
        else:
            # Recommend products based on holiday sales
            product_sales = near_holiday_data.groupby('product_id').agg(
                total_quantity=pd.NamedAgg(column='quantity', aggfunc='sum'),
                total_sales=pd.NamedAgg(column='total_price', aggfunc='sum')
            ).reset_index()

            product_sales = pd.merge(product_sales, self.products_data[['id', 'name']], left_on='product_id', right_on='id', how='inner')
            product_sales = product_sales.sort_values(by='total_sales', ascending=False)

            self.recommended_products = product_sales[['product_id', 'name', 'total_sales', 'total_quantity']].head(10)
            print("Recommended products near holidays:")
            print(self.recommended_products)

    def recommend_most_sold(self):
        # Recommend most sold products generally (based on all time sales)
        all_sales_data = self.merged_data.groupby('product_id').agg(
            total_quantity=pd.NamedAgg(column='quantity', aggfunc='sum'),
            total_sales=pd.NamedAgg(column='total_price', aggfunc='sum')
        ).reset_index()

        all_sales_data = pd.merge(all_sales_data, self.products_data[['id', 'name']], left_on='product_id', right_on='id', how='inner')
        all_sales_data = all_sales_data.sort_values(by='total_sales', ascending=False)

        self.recommended_products = all_sales_data[['product_id', 'name', 'total_sales', 'total_quantity']].head(10)
        print("Most sold products (general recommendations):")
        print(self.recommended_products)

    def get_recommendations(self):
        # This method returns the final list of recommended products as a serializable dictionary
        if self.recommended_products is not None:
            return self.recommended_products.to_dict(orient='records')
        else:
            return "No recommendations found."
 