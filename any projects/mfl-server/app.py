from flask import Flask, request, jsonify
from passlib.hash import sha256_crypt
import gc
import pymongo # MongoDB
from pymongo import MongoClient
import datetime
import os
import secrets
# from schemas.user import *


client = MongoClient('mongodb+srv://new_user31:9HcTgLescSuYgnR2@mfl.q93i6.mongodb.net/mfl?retryWrites=true&w=majority')
db = client.mfl

app = Flask(__name__)

@app.route('/register/', methods=["POST", 'GET'])
def register():
    try:
        user = {"username": "",
        "email": "",
        "password": "",
        "token": "token",
        "registered": "",
        }

        user['username']  = request.json['username']
        user['email'] = request.json['email']
        user['password'] = sha256_crypt.encrypt((str(request.json['password'])))
        user['registered'] = datetime.datetime.now()
        user['token'] = secrets.token_hex(32)

        users = db.users

        try:
            users.find({'email' : user['email']})[0]
        except Exception as e:
            try:
                users.find({'username' : user['username']})[0]
            except Exception as e:
                if str(e) == 'no such item for Cursor instance':
                    print('Created new user ' + user['username'])
                    users.insert_one(user)

                    return jsonify({"token": user['token']}), 200

        return jsonify({'message': 'registration failed'}), 401

    except Exception as e:
        print('Exception: ' + str(e))
        return jsonify({'message': 'registration failed'}), 401
		

@app.route('/login/', methods=["GET","POST"])
def login_page():
    try:
        if request.method == "POST":

            user = db.users.find({'username' : request.json['username']})[0]

            if sha256_crypt.verify(request.json['password'], user['password']):
                print('Logged in user ' + user['username'])
                return jsonify({"token": user['token']}), 200

            else:
                return jsonify({'message': 'signing in failed'}), 401

        gc.collect()
        return jsonify({'message': 'signing in failed'}), 401

    except Exception as e:
        print('Exception: ' + str(e)) 
        return jsonify({'message': 'signing in failed'}), 401


# Start flask server
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=int(os.environ.get('PORT', 5000)))
