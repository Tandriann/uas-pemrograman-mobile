import 'package:flutter/material.dart';
import 'package:flutter_laravel_app/screens/homepage.dart';

void main() {
  runApp(MyApp());

}

class MyApp extends StatelessWidget {
  const MyApp({
    super.key,
  });

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Order Online',
      home: HomePage(),
    );
  }
}

