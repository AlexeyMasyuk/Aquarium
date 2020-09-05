using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;

namespace ComputerToArduino
{
    public class ButtonsAndTextBoxesControl
    {
        private Button connect;
        private Button refresh;
        private Button write;
        private TextBox wifiPass;
        private TextBox userName;
        private TextBox userPass;

        public ButtonsAndTextBoxesControl
            (Button connectBtn, Button refreshBtn, Button writeBtn,
                TextBox wifiPassBox, TextBox userNameBox, TextBox userPassBox)
        {
            ConnectBtn = connectBtn;
            RefreshBtn = refreshBtn;
            WriteBtn = writeBtn;
            WifiPassBox = wifiPassBox;
            UserNameBox = userNameBox;
            UserPassBox = userPassBox;
            DisableOrEnableAll(false);
        }

        public Button ConnectBtn
        {
            get
            {
                return connect;
            }
            set
            {
                connect = value;
            }
        }
        public Button RefreshBtn
        {
            get
            {
                return refresh;
            }
            set
            {
                refresh = value;
            }
        }
        public Button WriteBtn
        {
            get
            {
                return write;
            }
            set
            {
                write = value;
            }
        }
        public TextBox WifiPassBox
        {
            get
            {
                return wifiPass;
            }
            set
            {
                wifiPass = value;
            }
        }
        public TextBox UserNameBox
        {
            get
            {
                return userName;
            }
            set
            {
                userName = value;
            }
        }
        public TextBox UserPassBox
        {
            get
            {
                return userPass;
            }
            set
            {
                userPass = value;
            }
        }

        public void DisableOrEnableAll(bool state)
        {           
            WriteBtn.Enabled = state;
            WifiPassBox.Enabled = state;
            UserNameBox.Enabled = state;
            UserPassBox.Enabled = state;
        }

        public void textClear()
        {
            WifiPassBox.Text = "";
            UserNameBox.Text = "";
            UserPassBox.Text = "";
        }

        public bool textValidation()
        {
            if (WifiPassBox.Text.Length > 0 && UserNameBox.Text.Length > 0 && UserPassBox.Text.Length > 0)
                return true;
            return false;
        }

        public void ConnectBtnStatusSwitch(bool swichCondition)
        {
            if (swichCondition)
                ConnectBtn.Enabled = true;
            else
                ConnectBtn.Enabled = false;
        }

        public void ConnectDisconnect_Switch()
        {
            if (ConnectBtn.Text.ToString() == "Connect")
                ConnectBtn.Text = "Disconnect";
            else
                ConnectBtn.Text = "Connect";
        }

        public string ComunicationString(string wifiName)
        {
            string[] strArr = { wifiName, WifiPassBox.Text.ToString(), UserNameBox.Text.ToString(), UserPassBox.Text.ToString() };
            string[] signs = { "<OKEY", " ", "\n" };
            StringBuilder str = null;
            for (int i = 0; i < 4; i++)
            {
                if (i == 0)
                    str.Append(signs[i]);
                str.Append(strArr[i]);
                str.Append(signs[1]);
                if (i == 3)
                    str.Append(signs[i - 1]);
            }
            return str.ToString();
        }

        public void writeBtnVision(bool isConnected,int wifiItemsCount)
        {
            if (textValidation() && isConnected && wifiItemsCount > 0)
                WriteBtn.Enabled = true;
            else
                WriteBtn.Enabled = false;
        }

    }
}

