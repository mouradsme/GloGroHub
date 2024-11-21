from flask import Flask, jsonify
import subprocess
from ProductRecommender import ProductRecommender
from ProductRecommenderByHolidaySales import ProductRecommenderByHolidaySales
import sys
import json
import logging

# Set up logging configuration
logging.basicConfig(
    filename='app.log',  # Log file location
    level=logging.DEBUG,  # Log level (DEBUG for detailed logs, ERROR for errors only)
    format='%(asctime)s - %(levelname)s - %(message)s'
)

sys.stdout.reconfigure(encoding='utf-8')

db_config = {
    'host': 'localhost',  # Database host
    'user': 'root',       # Database username
    'password': '12345678',  # Database password
    'database': 'grohub',  # Database name
    'charset': 'utf8',
    'ssl_disabled': True
}

app = Flask(__name__)
@app.route('/test', methods=['GET'])
def test():
    try:
        return jsonify({"message": "Test route is working!"}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/recommend-products-by-holiday-sales', methods=['GET'])
def recommend_products_by_holiday_sales():
    try:
        logging.info("Received request to recommend products by holiday sales.")
        recommender = ProductRecommenderByHolidaySales(db_config)
        recommender.load_data()
        recommender.merge_data()
        recommender.recommend_by_holiday_sales()

        recommendations = recommender.get_recommendations()
        logging.info("Recommendations generated successfully.")
        return jsonify(recommendations), 200
    except Exception as e:
        logging.error(f"Error in recommend_products_by_holiday_sales: {str(e)}")
        return jsonify({"error": str(e)}), 500

@app.route('/recommend-products/<int:id>', methods=['GET'])
def recommend_products(id):
    try:
        logging.info(f"Received request to recommend products for user ID: {id}.")
        recommender = ProductRecommender(db_config)
        top_n_recommendations = recommender.predict_and_recommend(id, top_n=5)

        logging.info(f"Recommendations for user {id} generated successfully.")
        return jsonify(top_n_recommendations), 200
    except Exception as e:
        logging.error(f"Error in recommend_products for user ID {id}: {str(e)}")
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000, ssl_context=None)

