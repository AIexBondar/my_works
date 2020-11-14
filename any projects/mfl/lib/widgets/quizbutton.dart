import 'package:flutter/material.dart';
import 'package:myFinLab/pages/quiz.dart';
import 'package:myFinLab/pages/quizResultsPage.dart';
import 'package:myFinLab/utils/constants.dart';


class QuizButton extends StatelessWidget {
  QuizButton(this.color1, this.color2, this.text, this.page, this.index, this.correctIndex);

  final int color1, color2, page, index, correctIndex;
  final String text;


  Widget build(BuildContext context) {
      return Padding(
          padding: const EdgeInsets.all(4.0),
            child: Container(
                child: 
                  RaisedButton(
                    onPressed: () {
                      if (page == 0){
                        if (Constants.prefs.getInt('quiz') == null){
                          Constants.prefs.setInt('quiz', 0);
                        }else{
                          Constants.prefs.setInt('quiz', 0);
                        }
                      }

                      
                      if (index == correctIndex){
                          Constants.prefs.setInt('quiz', Constants.prefs.getInt('quiz') + 1);
                      }

                      if (page == 9){
                        Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => QuizResultsPage(Constants.prefs.getInt('quiz')),
                      ));
                      }else{
                        Navigator.push(
                        context,
                        MaterialPageRoute(builder: (context) => QuizRoute(questionIndex: page+1)),
                      );
                      }

                    },
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(24.0)),
                    padding: EdgeInsets.all(0.0),
                    child: Stack( children:[ Ink(
                    decoration: BoxDecoration(
                      gradient: LinearGradient(colors: [Color(color1), Color(color2)],
                        begin: Alignment.centerLeft,
                        end: Alignment.centerRight,
                      ),
                      borderRadius: BorderRadius.circular(24.0),
                    ),
                    ),
                    Center(child: Text(text,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 20,
                      color: Colors.white,
                      fontWeight: FontWeight.w400,
                      fontFamily: 'Nunito'
                    ),))
              ]),
            )
          ),
      );
      }
  }