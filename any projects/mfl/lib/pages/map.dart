import 'package:flutter/material.dart';
import '../widgets/upperpoints.dart';

void main() => runApp(Menu());

class Menu extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Directionality(
      textDirection: TextDirection.ltr,
      child: Material(
        child: Stack(
          children: <Widget>[
            Map(),
            Positioned(
              child: UpperPointWidget(),
              top: 40,
              right: 20,
            ),
            Positioned(
              child: Stroke4(),
              right: 6,
              top: 325,
            ),
            Positioned(child: Stroke5(), right: 100, top: 320),
            Positioned(
              child: Stroke1(),
              bottom: 75,
              left: 95,
            ),
            Positioned(
              child: Stroke2(),
              bottom: 155,
              left: 115,
            ),
            Positioned(
              child: Stroke3(),
              bottom: 265,
              left: 80,
            ),
            Positioned(
              child: Monument(),
              right: 65,
              top: 400,
            ),
            Positioned(
              child: HomeText(),
              right: 20,
              top: 307,
            ),
            Positioned(
              child: Home(),
              right: 6,
              top: 225,
            ),
            Positioned(
              child: DocumentText(),
              bottom: 30,
              left: 38,
            ),
            Positioned(
              child: Document(),
              bottom: 65,
              left: 45,
            ),
            Positioned(
              child: BagText(),
              bottom: 165,
              left: 60,
            ),
            Positioned(
              child: Bag(),
              bottom: 200,
              left: 65,
            ),
            Positioned(
              child: ChestText(),
              bottom: 300,
              left: 50,
            ),
            Positioned(
              child: Chest(),
              bottom: 315,
              left: 40,
            ),
            Positioned(
              child: SwordText(),
              top: 280,
              right: 123,
            ),
            Positioned(
              child: Sword(),
              top: 200,
              right: 126,
            )
          ],
        ),
      ),
    );
  }
}

class Map extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      margin: EdgeInsets.only(top: 10),
      width: double.infinity,
      decoration: BoxDecoration(
        image: DecorationImage(
            image: AssetImage("assets/map.png"), fit: BoxFit.cover),
      ),
      child: null,
    );
  }
}

class Monument extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        highlightColor: Colors.transparent,
        splashColor: Colors.transparent,
        enableFeedback: false,
        onTap: () {
          debugPrint('Button Clicked');
        },
        child: Image.asset(
          'assets/monument.png',
          width: 150,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Stroke4 extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      child: Material(
        color: Colors.transparent,
        child: Image.asset(
          'assets/Stroke4.png',
          width: 125,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Stroke1 extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      child: Material(
        color: Colors.transparent,
        child: Image.asset(
          'assets/Stroke1.png',
          width: 165,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Stroke2 extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      child: Material(
        color: Colors.transparent,
        child: Image.asset(
          'assets/Stroke2.png',
          width: 165,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Stroke3 extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      child: Material(
        color: Colors.transparent,
        child: Image.asset(
          'assets/Stroke3.png',
          width: 165,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Stroke5 extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      child: Material(
        color: Colors.transparent,
        child: Image.asset(
          'assets/Stroke5.png',
          width: 90,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Home extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        highlightColor: Colors.transparent,
        splashColor: Colors.transparent,
        enableFeedback: false,
        onTap: () {
          debugPrint('Button Clicked');
        },
        child: Image.asset(
          'assets/home.png',
          width: 100,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Document extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        highlightColor: Colors.transparent,
        splashColor: Colors.transparent,
        enableFeedback: false,
        onTap: () {
          debugPrint('Button Clicked');
        },
        child: Image.asset(
          'assets/document.png',
          width: 100,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Bag extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        highlightColor: Colors.transparent,
        splashColor: Colors.transparent,
        enableFeedback: false,
        onTap: () {
          debugPrint('Button Clicked');
        },
        child: Image.asset(
          'assets/bag.png',
          width: 85,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Sword extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        highlightColor: Colors.transparent,
        splashColor: Colors.transparent,
        enableFeedback: false,
        onTap: () {
          debugPrint('Button Clicked');
        },
        child: Image.asset(
          'assets/sword.png',
          width: 100,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class Chest extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Material(
      color: Colors.transparent,
      child: InkWell(
        highlightColor: Colors.transparent,
        splashColor: Colors.transparent,
        enableFeedback: false,
        onTap: () {
          debugPrint('Button Clicked');
        },
        child: Image.asset(
          'assets/chest.png',
          width: 100,
          fit: BoxFit.cover,
        ),
      ),
    );
  }
}

class HomeText extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: 72,
      height: 36,
      decoration: BoxDecoration(
          border: Border.all(color: Colors.indigo[900]),
          color: Color(0xFF2C3C6A),
          borderRadius: BorderRadius.all(Radius.circular(20))),
      child: Center(
          child: Text(
        'Дом',
        style: TextStyle(
            fontSize: 15.0, color: Colors.white, fontFamily: 'Nunito'),
      )),
    );
  }
}

class DocumentText extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: 113,
      height: 60,
      decoration: BoxDecoration(
          border: Border.all(color: Colors.indigo[900]),
          color: Color(0xFF2C3C6A),
          borderRadius: BorderRadius.all(Radius.circular(40))),
      child: Center(
          child: Text(
        'Страховой полис',
        textAlign: TextAlign.center,
        style: TextStyle(
            fontSize: 15.0, color: Colors.white, fontFamily: 'Nunito'),
      )),
    );
  }
}

class SwordText extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: 106,
      height: 60,
      decoration: BoxDecoration(
          border: Border.all(color: Colors.indigo[900]),
          color: Color(0xFF2C3C6A),
          borderRadius: BorderRadius.all(Radius.circular(40))),
      child: Center(
          child: Text(
        'Игровой центр',
        textAlign: TextAlign.center,
        style: TextStyle(
            fontSize: 15.0, color: Colors.white, fontFamily: 'Nunito'),
      )),
    );
  }
}

class ChestText extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: 80,
      height: 36,
      decoration: BoxDecoration(
          border: Border.all(color: Colors.indigo[900]),
          color: Color(0xFF2C3C6A),
          borderRadius: BorderRadius.all(Radius.circular(40))),
      child: Center(
          child: Text(
        'Банк',
        textAlign: TextAlign.center,
        style: TextStyle(
            fontSize: 15.0, color: Colors.white, fontFamily: 'Nunito'),
      )),
    );
  }
}

class BagText extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      width: 95,
      height: 43,
      decoration: BoxDecoration(
          border: Border.all(color: Colors.indigo[900]),
          color: Color(0xFF2C3C6A),
          borderRadius: BorderRadius.all(Radius.circular(40))),
      child: Center(
          child: Text(
        'Магазин',
        textAlign: TextAlign.center,
        style: TextStyle(
            fontSize: 15.0, color: Colors.white, fontFamily: 'Nunito'),
      )),
    );
  }
}
