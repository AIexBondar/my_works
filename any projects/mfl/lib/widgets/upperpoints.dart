import 'package:flutter/material.dart';

class UpperPointWidget extends StatelessWidget{

  @override
  Widget build(BuildContext context) {
    return                 Row(
      mainAxisAlignment: MainAxisAlignment.end,
      children: [
        Row(
          children: [
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Image.asset('assets/lightng.png'),
            ),
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Text(
                "0",
                style: TextStyle(
                  fontFamily: 'Nunito',
                  fontSize: 18,
                  letterSpacing: 0.5,
                  color: Colors.white,
                  ),
                ),
            ),
            ]
          ),
          Row(
          children: [
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Image.asset('assets/Subtract.png'),
            ),
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Text(
                "0",
                style: TextStyle(
                  fontFamily: 'Nunito',
                  fontSize: 18,
                  letterSpacing: 0.5,
                  color: Colors.white,
                  ),
                ),
            ),
            ]
          ),
          Row(
          children: [
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Image.asset('assets/bit.png'),
            ),
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Text(
                "0",
                style: TextStyle(
                  fontFamily: 'Nunito',
                  fontSize: 18,
                  letterSpacing: 0.5,
                  color: Colors.white,
                  ),
                ),
            ),
            ]
          ),
          Row(
          children: [
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Image.asset('assets/Vector.png'),
            ),
            Padding(
              padding: const EdgeInsets.all(4.4),
              child: Text(
                "0",
                style: TextStyle(
                  fontFamily: 'Nunito',
                  fontSize: 18,
                  letterSpacing: 0.5,
                  color: Colors.white,
                  ),
                ),
            ),
            ]
          ),
      ],
    );
  }
  }