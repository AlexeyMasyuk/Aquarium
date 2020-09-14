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
         */
    }
}
