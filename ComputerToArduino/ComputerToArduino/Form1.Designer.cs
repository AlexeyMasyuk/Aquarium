namespace ComputerToArduino
{
    partial class CredToAquaController
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.connectBtn = new System.Windows.Forms.Button();
            this.portsBox = new System.Windows.Forms.ComboBox();
            this.wifiPassTextBox = new System.Windows.Forms.TextBox();
            this.groupBox2 = new System.Windows.Forms.GroupBox();
            this.refreshBtn = new System.Windows.Forms.Button();
            this.groupBox3 = new System.Windows.Forms.GroupBox();
            this.userNameTextBox = new System.Windows.Forms.TextBox();
            this.wifiList = new System.Windows.Forms.ListView();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader3 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.groupBox4 = new System.Windows.Forms.GroupBox();
            this.userPassTextBox = new System.Windows.Forms.TextBox();
            this.writeBtn = new System.Windows.Forms.Button();
            this.label1 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.dataPullingBox = new System.Windows.Forms.TextBox();
            this.groupBox2.SuspendLayout();
            this.groupBox3.SuspendLayout();
            this.groupBox1.SuspendLayout();
            this.groupBox4.SuspendLayout();
            this.SuspendLayout();
            // 
            // connectBtn
            // 
            this.connectBtn.Location = new System.Drawing.Point(5, 31);
            this.connectBtn.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.connectBtn.Name = "connectBtn";
            this.connectBtn.Size = new System.Drawing.Size(91, 34);
            this.connectBtn.TabIndex = 0;
            this.connectBtn.Text = "Connect";
            this.connectBtn.UseVisualStyleBackColor = true;
            this.connectBtn.Click += new System.EventHandler(this.connect_Click);
            // 
            // portsBox
            // 
            this.portsBox.FormattingEnabled = true;
            this.portsBox.Location = new System.Drawing.Point(139, 31);
            this.portsBox.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.portsBox.Name = "portsBox";
            this.portsBox.Size = new System.Drawing.Size(93, 24);
            this.portsBox.TabIndex = 1;
            // 
            // wifiPassTextBox
            // 
            this.wifiPassTextBox.Enabled = false;
            this.wifiPassTextBox.Location = new System.Drawing.Point(5, 38);
            this.wifiPassTextBox.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.wifiPassTextBox.Multiline = true;
            this.wifiPassTextBox.Name = "wifiPassTextBox";
            this.wifiPassTextBox.PasswordChar = '*';
            this.wifiPassTextBox.Size = new System.Drawing.Size(167, 26);
            this.wifiPassTextBox.TabIndex = 2;
            this.wifiPassTextBox.TextChanged += new System.EventHandler(this.wifiPassTextBox_TextChanged);
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.refreshBtn);
            this.groupBox2.Controls.Add(this.portsBox);
            this.groupBox2.Controls.Add(this.connectBtn);
            this.groupBox2.Location = new System.Drawing.Point(20, 232);
            this.groupBox2.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Padding = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox2.Size = new System.Drawing.Size(375, 71);
            this.groupBox2.TabIndex = 9;
            this.groupBox2.TabStop = false;
            this.groupBox2.Text = "Serial Connection";
            // 
            // refreshBtn
            // 
            this.refreshBtn.Location = new System.Drawing.Point(279, 31);
            this.refreshBtn.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.refreshBtn.Name = "refreshBtn";
            this.refreshBtn.Size = new System.Drawing.Size(91, 34);
            this.refreshBtn.TabIndex = 12;
            this.refreshBtn.Text = "Refresh";
            this.refreshBtn.UseVisualStyleBackColor = true;
            this.refreshBtn.Click += new System.EventHandler(this.refresh_Click);
            // 
            // groupBox3
            // 
            this.groupBox3.Controls.Add(this.wifiPassTextBox);
            this.groupBox3.Location = new System.Drawing.Point(15, 356);
            this.groupBox3.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox3.Name = "groupBox3";
            this.groupBox3.Padding = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox3.Size = new System.Drawing.Size(179, 108);
            this.groupBox3.TabIndex = 10;
            this.groupBox3.TabStop = false;
            this.groupBox3.Text = "Enter Wifi Password Here";
            // 
            // userNameTextBox
            // 
            this.userNameTextBox.Enabled = false;
            this.userNameTextBox.Location = new System.Drawing.Point(29, 39);
            this.userNameTextBox.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.userNameTextBox.Multiline = true;
            this.userNameTextBox.Name = "userNameTextBox";
            this.userNameTextBox.Size = new System.Drawing.Size(167, 26);
            this.userNameTextBox.TabIndex = 2;
            this.userNameTextBox.TextChanged += new System.EventHandler(this.userNameTextBox_TextChanged);
            // 
            // wifiList
            // 
            this.wifiList.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1,
            this.columnHeader3});
            this.wifiList.FullRowSelect = true;
            this.wifiList.GridLines = true;
            this.wifiList.HideSelection = false;
            this.wifiList.Location = new System.Drawing.Point(20, 34);
            this.wifiList.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.wifiList.Name = "wifiList";
            this.wifiList.Size = new System.Drawing.Size(375, 183);
            this.wifiList.TabIndex = 11;
            this.wifiList.UseCompatibleStateImageBehavior = false;
            this.wifiList.View = System.Windows.Forms.View.Details;
            this.wifiList.SelectedIndexChanged += new System.EventHandler(this.listView1_SelectedIndexChanged);
            // 
            // columnHeader1
            // 
            this.columnHeader1.Text = "SSID";
            this.columnHeader1.Width = 140;
            // 
            // columnHeader3
            // 
            this.columnHeader3.Text = "Signal";
            this.columnHeader3.Width = 142;
            // 
            // groupBox1
            // 
            this.groupBox1.Controls.Add(this.wifiList);
            this.groupBox1.Controls.Add(this.groupBox2);
            this.groupBox1.Location = new System.Drawing.Point(15, 21);
            this.groupBox1.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Padding = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox1.Size = new System.Drawing.Size(416, 321);
            this.groupBox1.TabIndex = 9;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Connection";
            // 
            // groupBox4
            // 
            this.groupBox4.Controls.Add(this.userNameTextBox);
            this.groupBox4.Controls.Add(this.userPassTextBox);
            this.groupBox4.Location = new System.Drawing.Point(200, 356);
            this.groupBox4.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox4.Name = "groupBox4";
            this.groupBox4.Padding = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.groupBox4.Size = new System.Drawing.Size(231, 108);
            this.groupBox4.TabIndex = 10;
            this.groupBox4.TabStop = false;
            this.groupBox4.Text = "Enter UserName and Password for your site Account";
            // 
            // userPassTextBox
            // 
            this.userPassTextBox.Enabled = false;
            this.userPassTextBox.ImeMode = System.Windows.Forms.ImeMode.Disable;
            this.userPassTextBox.Location = new System.Drawing.Point(29, 71);
            this.userPassTextBox.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.userPassTextBox.Multiline = true;
            this.userPassTextBox.Name = "userPassTextBox";
            this.userPassTextBox.PasswordChar = '*';
            this.userPassTextBox.Size = new System.Drawing.Size(167, 26);
            this.userPassTextBox.TabIndex = 2;
            this.userPassTextBox.TextChanged += new System.EventHandler(this.userPassTextBox_TextChanged);
            // 
            // writeBtn
            // 
            this.writeBtn.Enabled = false;
            this.writeBtn.Location = new System.Drawing.Point(173, 530);
            this.writeBtn.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.writeBtn.Name = "writeBtn";
            this.writeBtn.Size = new System.Drawing.Size(91, 26);
            this.writeBtn.TabIndex = 4;
            this.writeBtn.Text = "Write";
            this.writeBtn.UseVisualStyleBackColor = true;
            this.writeBtn.Click += new System.EventHandler(this.write_Click);
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(33, 483);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(118, 16);
            this.label1.TabIndex = 11;
            this.label1.Text = "Data Pulling Every";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(230, 483);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(29, 16);
            this.label2.TabIndex = 12;
            this.label2.Text = "Min";
            // 
            // dataPullingBox
            // 
            this.dataPullingBox.Enabled = false;
            this.dataPullingBox.Location = new System.Drawing.Point(157, 480);
            this.dataPullingBox.Name = "dataPullingBox";
            this.dataPullingBox.Size = new System.Drawing.Size(67, 22);
            this.dataPullingBox.TabIndex = 13;
            this.dataPullingBox.TextChanged += new System.EventHandler(this.dataPullingBox_TextChanged);
            // 
            // CredToAquaController
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(453, 575);
            this.Controls.Add(this.dataPullingBox);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.groupBox4);
            this.Controls.Add(this.groupBox3);
            this.Controls.Add(this.writeBtn);
            this.Controls.Add(this.groupBox1);
            this.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.MaximizeBox = false;
            this.Name = "CredToAquaController";
            this.Text = "CredToAquaController";
            this.groupBox2.ResumeLayout(false);
            this.groupBox3.ResumeLayout(false);
            this.groupBox3.PerformLayout();
            this.groupBox1.ResumeLayout(false);
            this.groupBox4.ResumeLayout(false);
            this.groupBox4.PerformLayout();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.Button connectBtn;
        private System.Windows.Forms.ComboBox portsBox;
        private System.Windows.Forms.TextBox wifiPassTextBox;
        private System.Windows.Forms.GroupBox groupBox2;
        private System.Windows.Forms.GroupBox groupBox3;
        private System.Windows.Forms.ListView wifiList;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private System.Windows.Forms.ColumnHeader columnHeader3;
        private System.Windows.Forms.Button refreshBtn;
        private System.Windows.Forms.GroupBox groupBox1;
        private System.Windows.Forms.TextBox userNameTextBox;
        private System.Windows.Forms.GroupBox groupBox4;
        private System.Windows.Forms.TextBox userPassTextBox;
        private System.Windows.Forms.Button writeBtn;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.TextBox dataPullingBox;
    }
}

