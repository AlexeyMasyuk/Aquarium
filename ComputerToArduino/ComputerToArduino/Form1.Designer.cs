namespace ComputerToArduino
{
    partial class Form1
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
            this.groupBox2.SuspendLayout();
            this.groupBox3.SuspendLayout();
            this.groupBox1.SuspendLayout();
            this.groupBox4.SuspendLayout();
            this.SuspendLayout();
            // 
            // connectBtn
            // 
            this.connectBtn.Location = new System.Drawing.Point(4, 25);
            this.connectBtn.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.connectBtn.Name = "connectBtn";
            this.connectBtn.Size = new System.Drawing.Size(68, 28);
            this.connectBtn.TabIndex = 0;
            this.connectBtn.Text = "Connect";
            this.connectBtn.UseVisualStyleBackColor = true;
            this.connectBtn.Click += new System.EventHandler(this.connect_Click);
            // 
            // portsBox
            // 
            this.portsBox.FormattingEnabled = true;
            this.portsBox.Location = new System.Drawing.Point(104, 25);
            this.portsBox.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.portsBox.Name = "portsBox";
            this.portsBox.Size = new System.Drawing.Size(71, 21);
            this.portsBox.TabIndex = 1;
            this.portsBox.SelectedIndexChanged += new System.EventHandler(this.comboBox1_SelectedIndexChanged);
            // 
            // wifiPassTextBox
            // 
            this.wifiPassTextBox.Location = new System.Drawing.Point(4, 31);
            this.wifiPassTextBox.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.wifiPassTextBox.Multiline = true;
            this.wifiPassTextBox.Name = "wifiPassTextBox";
            this.wifiPassTextBox.PasswordChar = '*';
            this.wifiPassTextBox.Size = new System.Drawing.Size(126, 22);
            this.wifiPassTextBox.TabIndex = 2;
            this.wifiPassTextBox.TextChanged += new System.EventHandler(this.textBox1_TextChanged);
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.refreshBtn);
            this.groupBox2.Controls.Add(this.portsBox);
            this.groupBox2.Controls.Add(this.connectBtn);
            this.groupBox2.Location = new System.Drawing.Point(15, 254);
            this.groupBox2.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Padding = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox2.Size = new System.Drawing.Size(281, 58);
            this.groupBox2.TabIndex = 9;
            this.groupBox2.TabStop = false;
            this.groupBox2.Text = "Serial Connection";
            // 
            // refreshBtn
            // 
            this.refreshBtn.Location = new System.Drawing.Point(209, 25);
            this.refreshBtn.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.refreshBtn.Name = "refreshBtn";
            this.refreshBtn.Size = new System.Drawing.Size(68, 28);
            this.refreshBtn.TabIndex = 12;
            this.refreshBtn.Text = "Refresh";
            this.refreshBtn.UseVisualStyleBackColor = true;
            this.refreshBtn.Click += new System.EventHandler(this.refresh_Click);
            // 
            // groupBox3
            // 
            this.groupBox3.Controls.Add(this.wifiPassTextBox);
            this.groupBox3.Location = new System.Drawing.Point(11, 338);
            this.groupBox3.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox3.Name = "groupBox3";
            this.groupBox3.Padding = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox3.Size = new System.Drawing.Size(134, 88);
            this.groupBox3.TabIndex = 10;
            this.groupBox3.TabStop = false;
            this.groupBox3.Text = "Enter Wifi Password Here";
            this.groupBox3.Enter += new System.EventHandler(this.groupBox3_Enter);
            // 
            // userNameTextBox
            // 
            this.userNameTextBox.Location = new System.Drawing.Point(22, 32);
            this.userNameTextBox.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.userNameTextBox.Multiline = true;
            this.userNameTextBox.Name = "userNameTextBox";
            this.userNameTextBox.Size = new System.Drawing.Size(126, 22);
            this.userNameTextBox.TabIndex = 2;
            this.userNameTextBox.TextChanged += new System.EventHandler(this.textBox1_TextChanged);
            // 
            // wifiList
            // 
            this.wifiList.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1,
            this.columnHeader3});
            this.wifiList.FullRowSelect = true;
            this.wifiList.GridLines = true;
            this.wifiList.HideSelection = false;
            this.wifiList.Location = new System.Drawing.Point(15, 28);
            this.wifiList.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.wifiList.Name = "wifiList";
            this.wifiList.Size = new System.Drawing.Size(282, 222);
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
            this.groupBox1.Location = new System.Drawing.Point(11, 17);
            this.groupBox1.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Padding = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox1.Size = new System.Drawing.Size(312, 316);
            this.groupBox1.TabIndex = 9;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Connection";
            this.groupBox1.Enter += new System.EventHandler(this.groupBox1_Enter);
            // 
            // groupBox4
            // 
            this.groupBox4.Controls.Add(this.userNameTextBox);
            this.groupBox4.Controls.Add(this.userPassTextBox);
            this.groupBox4.Location = new System.Drawing.Point(150, 338);
            this.groupBox4.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox4.Name = "groupBox4";
            this.groupBox4.Padding = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.groupBox4.Size = new System.Drawing.Size(173, 88);
            this.groupBox4.TabIndex = 10;
            this.groupBox4.TabStop = false;
            this.groupBox4.Text = "Enter UserName and Password for your site Account";
            this.groupBox4.Enter += new System.EventHandler(this.groupBox3_Enter);
            // 
            // userPassTextBox
            // 
            this.userPassTextBox.ImeMode = System.Windows.Forms.ImeMode.Disable;
            this.userPassTextBox.Location = new System.Drawing.Point(22, 58);
            this.userPassTextBox.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.userPassTextBox.Multiline = true;
            this.userPassTextBox.Name = "userPassTextBox";
            this.userPassTextBox.PasswordChar = '*';
            this.userPassTextBox.Size = new System.Drawing.Size(126, 22);
            this.userPassTextBox.TabIndex = 2;
            this.userPassTextBox.TextChanged += new System.EventHandler(this.textBox1_TextChanged);
            // 
            // writeBtn
            // 
            this.writeBtn.Location = new System.Drawing.Point(130, 431);
            this.writeBtn.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.writeBtn.Name = "writeBtn";
            this.writeBtn.Size = new System.Drawing.Size(68, 21);
            this.writeBtn.TabIndex = 4;
            this.writeBtn.Text = "Write";
            this.writeBtn.UseVisualStyleBackColor = true;
            this.writeBtn.Click += new System.EventHandler(this.write_Click);
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(351, 467);
            this.Controls.Add(this.groupBox4);
            this.Controls.Add(this.groupBox3);
            this.Controls.Add(this.writeBtn);
            this.Controls.Add(this.groupBox1);
            this.Margin = new System.Windows.Forms.Padding(2, 2, 2, 2);
            this.Name = "Form1";
            this.Text = "Computer to Arduino";
            this.Load += new System.EventHandler(this.Form1_Load);
            this.groupBox2.ResumeLayout(false);
            this.groupBox3.ResumeLayout(false);
            this.groupBox3.PerformLayout();
            this.groupBox1.ResumeLayout(false);
            this.groupBox4.ResumeLayout(false);
            this.groupBox4.PerformLayout();
            this.ResumeLayout(false);

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
    }
}

