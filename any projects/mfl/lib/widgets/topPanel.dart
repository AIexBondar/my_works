import 'package:flutter/material.dart';
import 'dart:async';

class topPanel extends StatefulWidget {

  int questionNumber;
  topPanel(this.questionNumber);

  @override
  _topPanelState createState() => _topPanelState();
}

class _topPanelState extends State<topPanel> {
  Timer _timer;

  int _start = 60;

  void startTimer() {
  const oneSec = const Duration(seconds: 1);
  _timer = new Timer.periodic(
    oneSec,
    (Timer timer) => setState(
      () {
        if (_start < 1) {
          timer.cancel();
        } else {
          _start = _start - 1;
        }
      },
    ),
    );
  }

  final timerTestStyle = TextStyle(
    color: Colors.white,
    fontSize: 20,
    fontFamily: 'Nunito',
    fontWeight: FontWeight.bold,      
  );

  @override
  void initState() {
    startTimer();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Center(
        child: Container(
          padding: EdgeInsets.all(16.0),
          child:
              Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: <Widget>[
                    Row(
                        children: <Widget>[CircularProgressIndicator(
                        value: 1 - _start / 60,
                        backgroundColor: Color(0xffE43C83),
                        valueColor: new AlwaysStoppedAnimation<Color>(Color(0xff2D3C6A)),
                      ),
                      Padding(
                        padding: const EdgeInsets.only(left: 18.0),
                        child: Text(
                          '00:' + _start.toString(),
                          style: timerTestStyle,
                        ),
                      )
                        ]),
                      Row(
                        children: <Widget> [
                        Row(
                            children: <Widget>[
                              Padding(
                                padding: const EdgeInsets.only(right: 18.0),
                                child: Text(
                                  this.widget.questionNumber.toString() + '/10',
                                  style: timerTestStyle,
                                ),
                              ),
                              CircularProgressIndicator(
                                value: 1 - this.widget.questionNumber/10,
                                backgroundColor: Color(0xffE43C83),
                                valueColor: new AlwaysStoppedAnimation<Color>(Color(0xff2D3C6A)),
                              ),
                                ]),
                            ]
                          )
                    ]
                )
        ),
      );
  }
}