import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:myFinLab/utils/constants.dart';
import 'package:myFinLab/pages/registration.dart';
import 'package:myFinLab/pages/quiz.dart';


class LoginPage extends StatelessWidget {

  final _formKey = GlobalKey<FormState>();
  final _usernameController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {

      final TStyle = TextStyle(
      fontFamily: 'Nunito',
      fontSize: 14,
      letterSpacing: 0.25,
      color: Colors.white,
    );


    final tStyleUpper = TextStyle(
      color: Color(0xff8598FF),
      fontFamily: 'Nunito',
      fontSize: 14,
      letterSpacing: 0.25,
    );


    final MainTStyle = TextStyle(
      fontFamily: 'Nunito',
      fontSize: 34,
      letterSpacing: 0.25,
      color: Colors.white,
    );


    Widget _AuthText()
    {
      return Center(
        child: Text(
          "Авторизація",
          style: MainTStyle,
          ),
      );
    }


    Widget _UpperFieldText(var text)
    {
      return Row(
        children: [
          Text(
            text,
            style: TStyle,
          )
        ],
      );
    }


    Widget _AbovePasswordText()
    {
      return Padding(
        padding: const EdgeInsets.only(top: 9.0),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Text(
              "Пароль",
              style: TStyle,
            ),
            Text(
              "Нагадати пароль",
              style: tStyleUpper,
            )
          ],
        ),
      );
    }


    final email = TextFormField(
      validator: (value) {
        if (value.isEmpty) {
          return 'Вкажіть ім\'я користувача';
        }
        return null;
      },
      controller: _usernameController,
      keyboardType: TextInputType.emailAddress,
      autofocus: false,
      style: TextStyle(color: Colors.black45),
      decoration: InputDecoration(
        filled: true,
        fillColor: Colors.white,
        labelStyle: new TextStyle(color: const Color(0xffffff)),
        hintText: "Ім'я користувача",
        contentPadding: EdgeInsets.fromLTRB(20.0, 10.0, 20.0, 10.0),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(5)),
      ),
    );


    final _passwordField = TextFormField(
      controller: _passwordController,
      validator: (value) {
        if (value.isEmpty) {
          return 'Вкажіть пароль';
        }
        return null;
      },
      keyboardType: TextInputType.text,
      obscureText: true,
      autofocus: false,
      style: TextStyle(color: Colors.black45),
      decoration: InputDecoration(
        filled: true,
        fillColor: Colors.white,
        labelStyle: new TextStyle(color: const Color(0xffffff)),
        hintText: '******',
        contentPadding: EdgeInsets.fromLTRB(20.0, 10.0, 20.0, 10.0),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(5)),
      ),
    );


    final _registerButton = FlatButton(
      onPressed: () {
          Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => RegisterPage()),
        );
      },
      child: Text(
      "Зареєструватися",
      style: TextStyle(
        fontSize: 18,
        fontFamily: 'Nunito',
        letterSpacing: 0.5,
        color: Color(0xff8598FF),
      ),
    ));


    final _signInWithButton = Padding(
      padding: const EdgeInsets.only(bottom: 16.0),
      child:Text(
      "Увійти за допомогою",
      style: TextStyle(
        fontFamily: 'Nunito',
        fontSize: 14,
        letterSpacing: 0.25,
        color: Colors.white,
      ),
    ),
    );

    final _socialRow = Row(
      mainAxisAlignment: MainAxisAlignment.spaceAround,
      children: [
        Image.asset('assets/g.png'),
        Image.asset('assets/f.png'),
        Image.asset('assets/i.png'),
    ],);


    final button = RaisedButton(
      onPressed: () async {
    // Validate returns true if the form is valid, otherwise false.
      if (_formKey.currentState.validate()) {
        // If the form is valid, display a snackbar. In the real world,
        // you'd often call a server or save the information in a database.
        var data = {
          'username': _usernameController.text,
          'password': _passwordController.text
        };

        var bodyEncoded = json.encode(data);
        var respo = await http.post('https://mfl-server.herokuapp.com/login/', body: bodyEncoded , headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
        },);
        final token = json.decode(respo.body)['token'];
        print(token);
        print(respo.body);

        if (token != null){ 
          Constants.prefs.setBool('LoggedIn', true);
          Constants.prefs.setString('token', token);

          
          while(Navigator.canPop(context)){
            Navigator.pop(context);
          }

          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => QuizRoute(questionIndex: 0)),
          );
        }
      }
      },
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(58.0)),
      padding: const EdgeInsets.all(0.0),
      child: Ink(
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: <Color>[Color(0xffFEEA7B), Color(0xffFFC97A)]),
          borderRadius: BorderRadius.all(Radius.circular(58.0)),
        ),
          child: Container(
          constraints: const BoxConstraints(minWidth: 88.0, minHeight: 44.0), // min sizes for Material buttons
          alignment: Alignment.center,
          child: const Text(
            'УВІЙТИ',
            textAlign: TextAlign.center,
            style: TextStyle(
              fontWeight: FontWeight.w600,
              fontSize: 14,
            ),
          ),
        ),
      ),
    );


    return Scaffold(
      
       // This trailing comma makes auto-formatting nicer for build methods.
       body: Container(
          child: Padding(
            padding: const EdgeInsets.only(top : 50, left: 15, right: 15, bottom: 32),
            child: SafeArea(
                child: SingleChildScrollView(
                    child: SizedBox(
                    height: MediaQuery.of(context).size.height - 105,
                    child: Column(
                      mainAxisSize: MainAxisSize.max,
                    children: [
                      _AuthText(),
                      Spacer(flex: 1),
                      Form(
                          key: _formKey,
                          child: Column(
                          children: [
                            _UpperFieldText("Ім'я користувача"),
                            email,
                            _AbovePasswordText(),
                            _passwordField,
                          ],
                        ),
                      ),
                      Padding(
                        padding: const EdgeInsets.only(top: 32.0, bottom: 16),
                        child: button,
                      ),
                      _registerButton,
                      Spacer(flex: 5),
                      _signInWithButton,
                      _socialRow
                    ],
                    ),
                  ),
                ),
            ),
          ),
          decoration: BoxDecoration(
          gradient: LinearGradient(
          begin: Alignment.topRight,
          end: Alignment.bottomLeft,
          colors: [Color(0xff2774AE), Color(0xff1A2B5F)])),
        ),
       );
  }
}