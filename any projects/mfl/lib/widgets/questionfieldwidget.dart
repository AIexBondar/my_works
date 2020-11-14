import 'package:flutter/material.dart';


class QuestionFieldWidget extends StatelessWidget {

  String mainText;

  QuestionFieldWidget(this.mainText);

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 118,
      decoration: new BoxDecoration(
        borderRadius: new BorderRadius.circular(24.0),
        color: Color(0xff2C3C6A),
      ) ,
        child: Padding(
        padding: const EdgeInsets.all(20.0),
        child: SingleChildScrollView (
          scrollDirection: Axis.vertical,
            child: Text(
            this.mainText,
            style: TextStyle(
            fontFamily: 'Nunito',
            fontSize: 16,
            letterSpacing: 0.25,
            color: Colors.white,
            fontWeight: FontWeight.normal,
            ),
          ),
        ),
      ));     
  }
}