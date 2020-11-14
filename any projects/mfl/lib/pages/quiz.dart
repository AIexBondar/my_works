import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import '../widgets/questionfieldwidget.dart';
import '../widgets/upperpoints.dart';
import '../widgets/topPanel.dart';
import '../widgets/quizbutton.dart';
import '../widgets/bottomMenu.dart';

class QuizRoute extends StatefulWidget {

  int questionIndex = 0;
  int correctIndex = 0;

  QuizRoute({this.questionIndex});

  @override
  _QuizRouteState createState() => _QuizRouteState();
}

class _QuizRouteState extends State<QuizRoute> {
  final grad = [0xffff5858, 0xffF09819, 0xff0BA360, 0xff3CBA92, 0xffF093FB, 0xffF5576C, 0xff00C6FB, 0xff005BEA];

  String questionText;

  List availableAnswers;

  Future<String> _loadCrosswordAsset() {
    return rootBundle.loadString('assets/data/quiz.json');
  }

  String jsonCrossword;

  Future<String> loadCrossword() async {
    return jsonCrossword = await _loadCrosswordAsset();
  }

  Map decoded;

  void _parseJsonForCrossword(String jsonString) {
    this.decoded = jsonDecode(jsonString);
    this.setState(() {
      _loadData();
    });
  }

  void _loadData(){
    questionText = decoded == null ? 'Text' : this.decoded['questions'][widget.questionIndex]['question'];
    availableAnswers = decoded == null ? 'Text' : this.decoded['questions'][widget.questionIndex]['answers'];
    super.widget.correctIndex = decoded == null ? 0 : this.decoded['questions'][widget.questionIndex]['correctIndex'];
  }

  @override
  void initState() {
    this.loadCrossword().then((value) { this._parseJsonForCrossword(value);});
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Material(
        color: Color(0xff132C5F),
        child: SafeArea(
            child: Padding(
              padding: const EdgeInsets.only(left: 16.0, right: 16.0),
              child: Column(
              children: [
                Spacer(),
                UpperPointWidget(),
                Spacer(),
                topPanel(super.widget.questionIndex+1),
                Spacer(),
                QuestionFieldWidget(this.questionText == null ? 'Text' : this.questionText),
                Spacer(),
                GridView.builder(
                shrinkWrap: true,
                physics: NeverScrollableScrollPhysics(),
                primary: false,
                padding: EdgeInsets.all(5),
                itemCount: 4,
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 2,
                  childAspectRatio: 200 / 200,
                ),
                itemBuilder: (BuildContext context, int index) {
                  return QuizButton(grad[index * 2], grad[index * 2 + 1], availableAnswers == null ? "answer" : availableAnswers[index], super.widget.questionIndex, index, super.widget.correctIndex);}
              ),
              Spacer(),
              BottomMenu(),
              Spacer(),
              Spacer(),
              ],
              ),
            ),
        ),
      );
  }
}