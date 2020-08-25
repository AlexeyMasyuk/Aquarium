using NativeWifi;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO.Ports;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;



namespace WindowsFormsApp1
{

    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            btnSend.Enabled = false;
        }

        private void listView1_SelectedIndexChanged(object sender, EventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            portFind();
        }

        private void comboBox1_SelectedIndexChanged(object sender, EventArgs e)
        {

        }

        private void Form1_Load(object sender, EventArgs e)
        {
            string[] ports = SerialPort.GetPortNames();
            cboPort.Items.AddRange(ports);
            cboPort.SelectedIndex = 0;
        }

        private void btnSend_Click(object sender, EventArgs e)
        {
            btnSend.Enabled = false;
            try
            {
                this.open();
                this.write();
                this.close();

                MessageBox.Show("Wifi Information Passed.", "Secssed" , MessageBoxButtons.OK, MessageBoxIcon.Information);

                btnSend.Enabled = true;
            }
            catch (Exception ex)
            {
                btnSend.Enabled = true;
                MessageBox.Show(ex.GetBaseException().ToString(), "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void textBox1_TextChanged(object sender, EventArgs e)
        {

        }

        private void label2_Click(object sender, EventArgs e)
        {

        }

        private void portFind()
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
                    item.SubItems.Add(network.dot11DefaultCipherAlgorithm.ToString());
                    item.SubItems.Add(network.wlanSignalQuality + "%");
                    listView1.Items.Add(item);
                }
            }
            btnSend.Enabled = true;
        }

        private void open()
        {
            if (serialPort1.PortName.Length == 0)
                throw new Exception("No Port Selected");
            if (!serialPort1.IsOpen)
                serialPort1.Close();
            serialPort1.PortName = cboPort.Text;
            serialPort1.WriteTimeout = 600;
            serialPort1.Open();
            serialPort1.BaudRate = 9600;
            if (!serialPort1.IsOpen)
                throw new Exception("Error opening " + serialPort1.PortName);
        }

        private void close()
        {
            serialPort1.Close();
            if (serialPort1.IsOpen)
                throw new Exception("Error closing " + serialPort1.PortName);
        }

        private void write()
        {
            var data = new byte[listView1.SelectedItems[0].Text.Length];
            int k = 0;
           foreach (char c in listView1.SelectedItems[0].Text)
            {
                data[k++] = (byte)c;
            }
            for(int i=0;i<10;i++)
            {
                serialPort1.Write(data,0,data.Length);
            }
            MessageBox.Show(listView1.SelectedItems[0].Text + " " + pass.Text + "."); 
            Task.Delay(10000);
        }

        private bool readWait()
        {
            int readComplete = 0, counter = 0;
            while (counter < 50)
            {
                Task.Delay(100);
                if (serialPort1.ReadByte() > 0)
                    readComplete++;
                counter++;
            }
            if (readComplete == 0)
                return false;
            return true;
        }
    }
}