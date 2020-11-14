import 'package:flutter/material.dart';
import 'package:myFinLab/pages/login.dart';
import 'package:myFinLab/utils/constants.dart';


class BottomMenuButton extends StatelessWidget {

  BottomMenuButton(this.text, this.src);

  final String src;
  final String text;

  @override
  Widget build(BuildContext context) {
    return RaisedButton(
      elevation: 0,
      color: Color(0xff132C5F),
      onPressed: () {
        Constants.prefs.setBool('LoggedIn', false);

        while(Navigator.canPop(context)){
            Navigator.pop(context);
          }

          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => LoginPage()),
          );
      },
      child: Row( children:[
      Image.asset(src),
      Padding(
        padding: const EdgeInsets.only(left: 13.0),
        child: Text(text, style: TextStyle(color: Colors.white, fontSize: 16, fontFamily: 'Nunito', fontWeight: FontWeight.w400),),
      )
    ]
    ),);
  }
}