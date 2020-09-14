using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;

namespace ComputerToArduino
{
    public static class MAT
    {
        private static string[] message =
            { "Can't connect to Port", "No answer from arduino", "Arduino fail to write", "Arduino got it" };
        private static string[] head = { "Secssed", "Fail" };


        public static void ConnFail()
        {
            MessageBox.Show(message[0], head[1], MessageBoxButtons.OK);
        }

        public static string NoAns()
        {
            return message[1];
        }

        public static string WrFail()
        {
            return message[2];
        }

        public static void MessBox(string text)
        {
            MessageBox.Show(text, head[1], MessageBoxButtons.OK);
        }

        public static void Secssed()
        {
            MessageBox.Show(message[3], head[0], MessageBoxButtons.OK);
        }
    }
}
