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



        private void write_Click(object sender, EventArgs e)
        {
            string commStr = buttonsAndText.ComunicationString(wifiList.SelectedItems[0].Text.ToString());
            MAT.ArdRes();
            portsHandler.writeToPort(commStr);
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
