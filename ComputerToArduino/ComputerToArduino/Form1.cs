using NativeWifi;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.IO.Ports;
using System.Timers;

namespace ComputerToArduino
{
    public partial class Form1 : Form

    {
        bool isConnected = false;
        String[] ports;
        SerialPort port;


        public Form1()
        {
            InitializeComponent();
            disableControls();
            getAvailableComPorts();

            wifiFind();
            portFind();
        }

        private void connect_Click(object sender, EventArgs e)
        {
            if (!isConnected)
            {
                connectToArduino();
            } else
            {
                disconnectFromArduino();
            }
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

        private void connectToArduino()
        {
            isConnected = true;
            string selectedPort = comboBox1.GetItemText(comboBox1.SelectedItem);
            port = new SerialPort(selectedPort, 9600, Parity.None, 8, StopBits.One);
            try
            {
                port.Open();
            }catch(Exception e)
            {
                MessageBox.Show("Cannot open Port","PortFail", MessageBoxButtons.OK);
                return;
            }
            connect.Text = "Disconnect";
            enableControls();
        }


        private void disconnectFromArduino()
        {
            isConnected = false;
            port.Close();
            connect.Text = "Connect";
            disableControls();
            resetDefaults();
        }

        private bool AnsRead()
        {
            try {
                if (port.IsOpen)
                {
                    DateTime now = DateTime.Now;
                    DateTime prev = now;
                    string data_rx = "";
                    while (true)
                    {
                        if (now > prev.AddSeconds(10))
                        {
                            throw new Exception("No answer from arduino");
                        }
                        data_rx = port.ReadLine();
                        if (data_rx.Contains("OKEY"))
                        {
                            MessageBox.Show("Arduino got it", "Secssed", MessageBoxButtons.OK);
                            return true;
                        }
                        else if(data_rx.Contains("FALSE"))
                        {
                            MessageBox.Show("Arduino fail to write", "Fail", MessageBoxButtons.OK);
                            return false;
                        }
                        now = DateTime.Now;
                    }
                }
            }
            catch (Exception)
            {
                MessageBox.Show("No answer from arduino", "Fail", MessageBoxButtons.OK);
                return false;
            }
            
            return false;
        }

        private void failReset(object sender, EventArgs e)
        {

        }

        private void write_Click(object sender, EventArgs e)
        {
            
            if (isConnected)
            {
                string send = "<OKEY" + listView1.SelectedItems[0].Text + " " + wifiPass.Text + " " + userNm.Text + " " + userPs.Text + "\n";
                try
                {
                    port.Write(send);
                    disableControls();
                    System.Threading.Thread.Sleep(9000);
                    MessageBox.Show("Press OK to read answer from Arduino", "Continue", MessageBoxButtons.OK);
                    AnsRead();
                    enableControls();
                }
                catch (Exception)
                {
                    isConnected = false;
                    connect.Text = "Connect";
                    disableControls();
                    resetDefaults();
                    portFind();
                    MessageBox.Show("No arduino connected", "Fail", MessageBoxButtons.OK);
                }

            }
        }

        private void enableControls()
        {
            refresh.Enabled = true;
            wifiPass.Enabled = true;
            userNm.Enabled = true;
            userPs.Enabled = true;
            groupBox3.Enabled = true;
        }

        private void disableControls()
        {
            wifiPass.Enabled = false;
            userNm.Enabled = false;
            userPs.Enabled = false;
            groupBox3.Enabled = false;
            write.Enabled = false;
        }

        private void resetDefaults()
        {
            wifiPass.Text = "";
            userNm.Text = "";
            userPs.Text = "";
        }

        private void groupBox3_Enter(object sender, EventArgs e)
        {

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
        }

        private void wifiFind()
        {

            listView1.Items.Clear();
            WlanClient client = new WlanClient();
            foreach (WlanClient.WlanInterface wlanInterface in client.Interfaces)
            {
                Wlan.WlanAvailableNetwork[] networks = wlanInterface.GetAvailableNetworkList(0);
                foreach (Wlan.WlanAvailableNetwork network in networks)
                {
                    Wlan.Dot11Ssid ssid = network.dot11Ssid;
                    string networkName = Encoding.ASCII.GetString(ssid.SSID, 0, (int)ssid.SSIDLength);
                    ListViewItem item = new ListViewItem(networkName);
                    item.SubItems.Add(network.wlanSignalQuality + "%");
                    if(!listView1.Items.Contains(item))
                        listView1.Items.Add(item);
                }
            }
        }

        private void listView1_SelectedIndexChanged(object sender, EventArgs e)
        {
            if(listView1.SelectedItems.Count>0 && isConnected)
                write.Enabled = true;
            else
                write.Enabled = false;
        }

        /*------------------------------------------------------------------*/

        private void refresh_Click(object sender, EventArgs e)
        {
            wifiFind();
            portFind();
            resetDefaults();
        }

        private void textBox1_TextChanged(object sender, EventArgs e)
        {

        }

        private void groupBox1_Enter(object sender, EventArgs e)
        {

        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void comboBox1_SelectedIndexChanged(object sender, EventArgs e)
        {

        }
    }
}
