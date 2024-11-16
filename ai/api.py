from flask import Flask, jsonify
import subprocess
from ProductRecommender import ProductRecommender
from ProductRecommenderByHolidaySales import ProductRecommenderByHolidaySales
import sys
import json

sys.stdout.reconfigure(encoding='utf-8')
db_config = {
            'host': 'localhost',  # Database host
            'user': 'root',       # Database username
            'password': '12345678',  # Database password
            'database': 'grohub',  # Database name
            'charset': 'utf8'

        }


app = Flask(__name__)

@app.route('/recommend-products-by-holiday-sales', methods=['GET'])
def recommend_products_by_holiday_sales():
    # Run your Python script
    try:
 
        recommender = ProductRecommenderByHolidaySales(db_config)
        recommender.load_data()
        recommender.merge_data()
        recommender.recommend_by_holiday_sales()

        # Print final recommendations
        recommendations = recommender.get_recommendations()
        return jsonify(recommendations), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/recommend-products/<int:id>', methods=['GET'])
def recommend_products(id):
    # Run your Python script
    try:

        recommender = ProductRecommender(db_config)
        top_n_recommendations = recommender.predict_and_recommend(id, top_n=5)

        return jsonify(top_n_recommendations), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
