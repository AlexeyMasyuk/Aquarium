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
        private PortsHandler portsHandler;
        private ButtonsAndTextBoxesControl buttonsAndText;

        bool isConnected = false;
        String[] ports;
        SerialPort port;


        public Form1()
        {
            InitializeComponent();
            portsHandler = new PortsHandler(portsBox);
            buttonsAndText = new ButtonsAndTextBoxesControl
                (connectBtn, refreshBtn, writeBtn, wifiPassTextBox, userNameTextBox, userPassTextBox);
            buttonsAndText.ConnectBtnStatusSwitch(portsHandler.PortsNames.Length != 0);
            WlanClient.wifiFind(wifiList);
        }

        private void connectionControl()
        {
            if(isConnected)
                portsHandler.Port.Close();
            portsHandler.PortsBox.Enabled = isConnected;                          
            isConnected = !isConnected;
            buttonsAndText.DisableOrEnableAll(isConnected);
            buttonsAndText.ConnectDisconnect_Switch();
            buttonsAndText.WriteBtn.Enabled = false;
        }

        private void connect_Click(object sender, EventArgs e)
        {
            if (!isConnected)
            {
                if (!portsHandler.connectToPort(portsBox.SelectedItem.ToString()))
                    MAT.ConnFail();
                else
                    connectionControl();
            }
            else
                connectionControl();
        }

        private bool AnsRead()
        {
            try 
            {
                if (portsHandler.Port.IsOpen) 
                {
                    DateTime now = DateTime.Now;
                    DateTime prev = now;
                    string data_rx = "";
                    while (true)
                    {
                        if (now > prev.AddSeconds(10))
                            throw new Exception(MAT.NoAns());
                        data_rx = portsHandler.Port.ReadLine();
                        if (data_rx.Contains("OKEY"))
                            break;
                        else if (data_rx.Contains("FALSE"))
                            throw new Exception(MAT.WrFail());
                        now = DateTime.Now;
                    }
                    MAT.Secssed();
                    return true;
                }
            }
            catch (Exception e)
            {
                MessageBox.Show(e.Message.ToString(), "Fail", MessageBoxButtons.OK);                
            }
            return false;
        }

        private void write_Click(object sender, EventArgs e)
        {
            
            if (isConnected)
            {
                string commStr = buttonsAndText.ComunicationString(wifiList.SelectedItems[0].Text.ToString());
                string send = "<OKEY" + wifiList.SelectedItems[0].Text + " " + wifiPassTextBox.Text + " " + userNameTextBox.Text + " " + userPassTextBox.Text + "\n";
                try
                {
                    port.Write(send);
                    buttonsAndText.DisableOrEnableAll(false);
                    System.Threading.Thread.Sleep(9000);
                    MessageBox.Show("Press OK to read answer from Arduino", "Continue", MessageBoxButtons.OK);
                    AnsRead();
                    buttonsAndText.DisableOrEnableAll(true);
                }
                catch (Exception)
                {
                    isConnected = false;
                    connectBtn.Text = "Connect";
                    buttonsAndText.DisableOrEnableAll(false);
                    buttonsAndText.textClear();
                    portsHandler.PortsRefresh();
                    MessageBox.Show("No arduino connected", "Fail", MessageBoxButtons.OK);
                }

            }
        }

        private void listView1_SelectedIndexChanged(object sender, EventArgs e)
        {
            buttonsAndText.writeBtnVision(isConnected, wifiList.SelectedItems.Count);
        }

        /*------------------------------------------------------------------*/

        private void refresh_Click(object sender, EventArgs e)
        {
            WlanClient.wifiFind(wifiList);
            portsHandler.PortsRefresh();
            buttonsAndText.ConnectBtnStatusSwitch(portsHandler.PortsNames.Length != 0);
        }

        private void wifiPassTextBox_TextChanged(object sender, EventArgs e)
        {
            buttonsAndText.writeBtnVision(isConnected, wifiList.SelectedItems.Count);
        }

        private void userNameTextBox_TextChanged(object sender, EventArgs e)
        {
            buttonsAndText.writeBtnVision(isConnected, wifiList.SelectedItems.Count);
        }

        private void userPassTextBox_TextChanged(object sender, EventArgs e)
        {
            buttonsAndText.writeBtnVision(isConnected, wifiList.SelectedItems.Count);
        }
    }
}
