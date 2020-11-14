import 'package:flutter/material.dart';
import '../widgets/questionfieldwidget.dart';

class QuizResultsPage extends StatelessWidget {

  int points;

  QuizResultsPage(this.points);

  @override
  Widget build(BuildContext context) {
    return Material(
        color: Color(0xff132C5F),
        child: SafeArea(
                child: Center(child: QuestionFieldWidget('Congratulations! Your score: ' + points.toString())),
        )
    );
  }
}