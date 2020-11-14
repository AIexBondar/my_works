package com.company;

import java.awt.*;

import javax.swing.JButton;
import javax.swing.JComponent;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JTextField;

public class Okno extends JFrame{

    JButton przycisk;
    JTextField pole;
    JLabel label;

    public Okno() {

        przycisk = new JButton();
        pole = new JTextField();
        label = new JLabel("Tekst");

        setLayout( new FlowLayout() );

        JComponent mojComp = new JComponent() {

            public void paintComponent(Graphics g) {
                g.setColor(Color.RED);

                g.fillRect(5, 5, 15, 15);

            }

        };

        mojComp.setPreferredSize(new Dimension(100,100));

        przycisk.setPreferredSize(new Dimension(200, 200));
        pole.setPreferredSize(new Dimension(400, 200));


        getContentPane().add(przycisk);
        //getContentPane().add(pole, BorderLayout.PAGE_END);
        getContentPane().add(pole);
        getContentPane().add(label);
        getContentPane().add(mojComp);


        setSize(800, 600);
        setVisible(true);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);

    }


}
