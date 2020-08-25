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
            ConnectBtn.Enabled = state;
            WriteBtn.Enabled = state;
            WifiPassBox.Enabled = state;
            UserNameBox.Enabled = state;
            UserPassBox.Enabled = state;
        }
    }
}
