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
        private static string head = "Secssed";


        public static string ConnFail()
        {
            return message[0];
        }

        public static string NoAns()
        {
            return message[1];
        }

        public static string WrFail()
        {
            return message[2];
        }

        public static void Secssed()
        {
            MessageBox.Show(message[3], head, MessageBoxButtons.OK);
        }
    }
}
