using System;
using System.Collections.Generic;
using System.Text;

namespace ComputerToArduino
{
    class tmpFuncHolder
    {
/*        private void connectToArduino()
        {
            isConnected = true;
            string selectedPort = comboBox1.GetItemText(comboBox1.SelectedItem);
            port = new SerialPort(selectedPort, 9600, Parity.None, 8, StopBits.One);
            try
            {
                port.Open();
            }
            catch (Exception e)
            {
                MessageBox.Show("Cannot open Port", "PortFail", MessageBoxButtons.OK);
                return;
            }
            connect.Text = "Disconnect";
            enableControls();
        }

        void getAvailableComPorts()
        {
            port = null;
            ports = SerialPort.GetPortNames();
            if (ports.Length > 0)
                connect.Enabled = true;
            else
                connect.Enabled = false;
        }

        private void disconnectFromArduino()
        {
            isConnected = false;
            port.Close();
            connect.Text = "Connect";
            disableControls();
            resetDefaults();
        }

        private void portFind()
        {
            comboBox1.Items.Clear();
            comboBox1.Text = null;
            getAvailableComPorts();
            foreach (string port in ports)
            {
                comboBox1.Items.Add(port);
                Console.WriteLine(port);
                if (ports[0] != null)
                {
                    comboBox1.SelectedItem = ports[0];
                }
            }
        }*/
    }
}
