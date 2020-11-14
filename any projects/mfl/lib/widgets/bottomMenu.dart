import 'package:flutter/material.dart';
import '../widgets/bottomMenuButton.dart';


class BottomMenu extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Row(children: [
          BottomMenuButton('Вийти', 'assets/exit.png'),
        ]),
        Row(children: [
          BottomMenuButton('Підказати', 'assets/bulb.png'),
        ],)
      ],
    );
  }
}