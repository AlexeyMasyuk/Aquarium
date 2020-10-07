using System;
using System.Collections.Generic;
using System.IO.Ports;
using System.Text;
using System.Windows.Forms;

namespace ComputerToArduino
{
    public class PortsHandler
    {
        private string[] portsNames;
        private SerialPort port;
        private ComboBox portsBox;

        public PortsHandler(ComboBox portsBox)
        {
            PortsBox = portsBox;
            PortsNames = SerialPort.GetPortNames();
            portsToBox();           
        }

        public string[] PortsNames
        {
            get
            {
                return portsNames;
            }
            set
            {
                if (value != null)
                    portsNames = value;
            }
        }
        public ComboBox PortsBox
        {
            get
            {
                return portsBox;
            }
            set
            {
                portsBox = value;
            }
        }
        public SerialPort Port
        {
            get
            {
                return port;
            }
            set
            {
                port = value;
            }
        }

        private void portsToBox()
        {
            foreach (string port in PortsNames)
            {
                PortsBox.Items.Add(port);
                if (PortsNames[0] != null)
                    PortsBox.SelectedItem = PortsNames[0];
            }
        }

        public void PortsRefresh()
        {
            PortsNames = null;
            PortsBox.Items.Clear();
            PortsBox.Text = "";
            PortsNames = SerialPort.GetPortNames();
            portsToBox();
        }


        public bool connectToPort(string portName)
        {
            try
            {
                Port = new SerialPort(portName, 9600, Parity.None, 8, StopBits.One);
                Port.Open();
                PortsBox.Enabled = false;
                return Port.IsOpen;
            }
            catch (Exception e)
            {
                PortsBox.Enabled = true ;
                return false;
            }
        }

        public void disconnectFromPort()
        {
            Port.Close();
        }

        private void AnsRead()
        {
            if (Port.IsOpen)
            {
                Port.DiscardInBuffer();
                DateTime now = DateTime.Now;
                DateTime prev = now;
                string data_rx = "";
                while (true)
                {
                    if (now > prev.AddSeconds(10))
                        throw new Exception(MAT.NoAns());
                    try
                    {
                        data_rx = Port.ReadExisting();
                        
                    }
                    catch (Exception)
                    {
                        throw new Exception(MAT.NoAns());
                    }
                    if (data_rx.Contains("OKEY"))
                        break;
                    else if (data_rx.Contains("FALSE"))
                        throw new Exception(MAT.WrFail());
                    now = DateTime.Now;
                }
                MAT.Secssed();
            }
            throw new Exception(MAT.NoAns());
        }

        public bool writeToPort(string MessageToWrite)
        {
            try
            {
                Port.Write(MessageToWrite);
                System.Threading.Thread.Sleep(2000);
                AnsRead();
                return true;
            }
            catch (Exception e)
            {
                MAT.MessBox(e.Message);
                return false;
            }
        }
    }
}
