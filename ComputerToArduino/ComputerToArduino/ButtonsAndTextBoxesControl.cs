using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;

// Class controlling all button text and clickable ability.
// Need Button and TextBox objects to manipulate parameters within the object.

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
        private TextBox dataPulling;
        private TextBox highLevel;
        private TextBox lowLevel;

        // Class constructor, initiallizing object parameters,
        public ButtonsAndTextBoxesControl
            (Button connectBtn, Button refreshBtn, Button writeBtn, TextBox highLevel, TextBox lowLevel,
                TextBox wifiPassBox, TextBox userNameBox, TextBox userPassBox, TextBox dataPulling)
        {
            ConnectBtn = connectBtn;
            RefreshBtn = refreshBtn;
            WriteBtn = writeBtn;
            WifiPassBox = wifiPassBox;
            UserNameBox = userNameBox;
            UserPassBox = userPassBox;
            DataPulling = dataPulling;
            HighLevel = highLevel;
            LowLevel = lowLevel;
        }

        // Get/Set Methods
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
        public TextBox DataPulling
        {
            get
            {
                return dataPulling;
            }
            set
            {
                dataPulling = value;
            }
        }
        public TextBox HighLevel
        {
            get
            {
                return highLevel;
            }
            set
            {
                highLevel = value;
            }
        }
        public TextBox LowLevel
        {
            get
            {
                return lowLevel;
            }
            set
            {
                lowLevel = value;
            }
        }

        // Changing control state text boxes to be filled by user.
        public void UserBoxesAndBtnStateControll(bool state)
        {
            WifiPassBox.Enabled = state;
            UserNameBox.Enabled = state;
            UserPassBox.Enabled = state;
            DataPulling.Enabled = state;
            HighLevel.Enabled = state;
            LowLevel.Enabled = state;
            WriteBtn.Enabled = !state;
            ConnectDisconnect_Switch();
        }

        // Clearing text boxes.
        public void textClear()
        {
            WifiPassBox.Text = "";
            UserNameBox.Text = "";
            UserPassBox.Text = "";
            HighLevel.Text = "";
            LowLevel.Text = "";
            DataPulling.Text = "60";
        }

        // Validating text boxes not empty.
        public bool textValidation()
        {

            if (WifiPassBox.Text.Length > 0 && UserNameBox.Text.Length > 0 && UserPassBox.Text.Length > 0 && DataPulling.Text.Length > 0)
            {
                long number = 0;
                bool canConvert = long.TryParse(DataPulling.Text.ToString(), out number);
                bool canConvert1 = long.TryParse(LowLevel.Text.ToString(), out number);
                bool canConvert2 = long.TryParse(HighLevel.Text.ToString(), out number);
                if (canConvert && canConvert1 && canConvert2)
                {
                    return true;
                }               
            }
                
            return false;
        }

        // Swiching Connect button to given state in "swichCondition"
        public void ConnectBtnStatusSwitch(bool swichCondition)
        {
            ConnectBtn.Enabled = swichCondition;
        }

        // Changing connect button text to relevant text
        public void ConnectDisconnect_Switch()
        {
            if (ConnectBtn.Text.ToString() == "Connect")
                ConnectBtn.Text = "Disconnect";
            else
                ConnectBtn.Text = "Connect";
        }

        // Creating string to be sent to arduino,
        // containing OKEY as validation sign and wifi name and paswword, 
        // username, pasword for aqua site and EOL/'\n' as closer sign.
        // Returning the string
        public string ComunicationString(string wifiName)
        {
            long number = 0;
            int toMilliSecConv = 60000;
            bool canConvert = long.TryParse(DataPulling.Text.ToString(), out number);

            string[] strArr = { wifiName, WifiPassBox.Text.ToString(), UserNameBox.Text.ToString(), UserPassBox.Text.ToString(), (number * toMilliSecConv).ToString(), HighLevel.Text.ToString(),LowLevel.Text.ToString() };

            string[] signs = { "<OKEY", ",", ">" };
            StringBuilder str = new StringBuilder();
            for (int i = 0; i < strArr.Length; i++)
            {
                if (i == 0)
                    str.Append(signs[i]);
                str.Append(strArr[i]);
                if (i == strArr.Length-1)
                {
                    str.Append(signs[signs.Length - 1]);
                    break;
                }
                str.Append(signs[1]);
            }
            return str.ToString();
        }

        // Contrilling write buttton depending on presence of needed data to send.
        public void writeBtnVision(bool isConnected,int wifiSelectedItemsCount)
        {
            if (textValidation() && isConnected && wifiSelectedItemsCount > 0)
                WriteBtn.Enabled = true;
            else
                WriteBtn.Enabled = false;
        }

    }
}

