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
            this.connect = new System.Windows.Forms.Button();
            this.comboBox1 = new System.Windows.Forms.ComboBox();
            this.wifiPass = new System.Windows.Forms.TextBox();
            this.groupBox2 = new System.Windows.Forms.GroupBox();
            this.refresh = new System.Windows.Forms.Button();
            this.groupBox3 = new System.Windows.Forms.GroupBox();
            this.userNm = new System.Windows.Forms.TextBox();
            this.listView1 = new System.Windows.Forms.ListView();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader3 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.groupBox1 = new System.Windows.Forms.GroupBox();
            this.groupBox4 = new System.Windows.Forms.GroupBox();
            this.userPs = new System.Windows.Forms.TextBox();
            this.write = new System.Windows.Forms.Button();
            this.groupBox2.SuspendLayout();
            this.groupBox3.SuspendLayout();
            this.groupBox1.SuspendLayout();
            this.groupBox4.SuspendLayout();
            this.SuspendLayout();
            // 
            // connect
            // 
            this.connect.Location = new System.Drawing.Point(6, 31);
            this.connect.Name = "connect";
            this.connect.Size = new System.Drawing.Size(90, 34);
            this.connect.TabIndex = 0;
            this.connect.Text = "Connect";
            this.connect.UseVisualStyleBackColor = true;
            this.connect.Click += new System.EventHandler(this.connect_Click);
            // 
            // comboBox1
            // 
            this.comboBox1.FormattingEnabled = true;
            this.comboBox1.Location = new System.Drawing.Point(138, 31);
            this.comboBox1.Name = "comboBox1";
            this.comboBox1.Size = new System.Drawing.Size(93, 24);
            this.comboBox1.TabIndex = 1;
            this.comboBox1.SelectedIndexChanged += new System.EventHandler(this.comboBox1_SelectedIndexChanged);
            // 
            // wifiPass
            // 
            this.wifiPass.Location = new System.Drawing.Point(6, 38);
            this.wifiPass.Multiline = true;
            this.wifiPass.Name = "wifiPass";
            this.wifiPass.PasswordChar = '*';
            this.wifiPass.Size = new System.Drawing.Size(166, 26);
            this.wifiPass.TabIndex = 2;
            this.wifiPass.TextChanged += new System.EventHandler(this.textBox1_TextChanged);
            // 
            // groupBox2
            // 
            this.groupBox2.Controls.Add(this.refresh);
            this.groupBox2.Controls.Add(this.comboBox1);
            this.groupBox2.Controls.Add(this.connect);
            this.groupBox2.Location = new System.Drawing.Point(20, 312);
            this.groupBox2.Name = "groupBox2";
            this.groupBox2.Size = new System.Drawing.Size(375, 71);
            this.groupBox2.TabIndex = 9;
            this.groupBox2.TabStop = false;
            this.groupBox2.Text = "Serial Connection";
            // 
            // refresh
            // 
            this.refresh.Location = new System.Drawing.Point(279, 31);
            this.refresh.Name = "refresh";
            this.refresh.Size = new System.Drawing.Size(90, 34);
            this.refresh.TabIndex = 12;
            this.refresh.Text = "Refresh";
            this.refresh.UseVisualStyleBackColor = true;
            this.refresh.Click += new System.EventHandler(this.refresh_Click);
            // 
            // groupBox3
            // 
            this.groupBox3.Controls.Add(this.wifiPass);
            this.groupBox3.Location = new System.Drawing.Point(15, 416);
            this.groupBox3.Name = "groupBox3";
            this.groupBox3.Size = new System.Drawing.Size(179, 108);
            this.groupBox3.TabIndex = 10;
            this.groupBox3.TabStop = false;
            this.groupBox3.Text = "Enter Wifi Password Here";
            this.groupBox3.Enter += new System.EventHandler(this.groupBox3_Enter);
            // 
            // userNm
            // 
            this.userNm.Location = new System.Drawing.Point(29, 39);
            this.userNm.Multiline = true;
            this.userNm.Name = "userNm";
            this.userNm.Size = new System.Drawing.Size(166, 26);
            this.userNm.TabIndex = 2;
            this.userNm.TextChanged += new System.EventHandler(this.textBox1_TextChanged);
            // 
            // listView1
            // 
            this.listView1.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1,
            this.columnHeader3});
            this.listView1.FullRowSelect = true;
            this.listView1.GridLines = true;
            this.listView1.HideSelection = false;
            this.listView1.Location = new System.Drawing.Point(20, 35);
            this.listView1.Margin = new System.Windows.Forms.Padding(3, 2, 3, 2);
            this.listView1.Name = "listView1";
            this.listView1.Size = new System.Drawing.Size(375, 272);
            this.listView1.TabIndex = 11;
            this.listView1.UseCompatibleStateImageBehavior = false;
            this.listView1.View = System.Windows.Forms.View.Details;
            this.listView1.SelectedIndexChanged += new System.EventHandler(this.listView1_SelectedIndexChanged);
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
            this.groupBox1.Controls.Add(this.listView1);
            this.groupBox1.Controls.Add(this.groupBox2);
            this.groupBox1.Location = new System.Drawing.Point(15, 21);
            this.groupBox1.Name = "groupBox1";
            this.groupBox1.Size = new System.Drawing.Size(416, 389);
            this.groupBox1.TabIndex = 9;
            this.groupBox1.TabStop = false;
            this.groupBox1.Text = "Connection";
            this.groupBox1.Enter += new System.EventHandler(this.groupBox1_Enter);
            // 
            // groupBox4
            // 
            this.groupBox4.Controls.Add(this.userNm);
            this.groupBox4.Controls.Add(this.userPs);
            this.groupBox4.Location = new System.Drawing.Point(200, 416);
            this.groupBox4.Name = "groupBox4";
            this.groupBox4.Size = new System.Drawing.Size(231, 108);
            this.groupBox4.TabIndex = 10;
            this.groupBox4.TabStop = false;
            this.groupBox4.Text = "Enter UserName and Password for your site Account";
            this.groupBox4.Enter += new System.EventHandler(this.groupBox3_Enter);
            // 
            // userPs
            // 
            this.userPs.ImeMode = System.Windows.Forms.ImeMode.Disable;
            this.userPs.Location = new System.Drawing.Point(29, 71);
            this.userPs.Multiline = true;
            this.userPs.Name = "userPs";
            this.userPs.PasswordChar = '*';
            this.userPs.Size = new System.Drawing.Size(166, 26);
            this.userPs.TabIndex = 2;
            this.userPs.TextChanged += new System.EventHandler(this.textBox1_TextChanged);
            // 
            // write
            // 
            this.write.Location = new System.Drawing.Point(173, 530);
            this.write.Name = "write";
            this.write.Size = new System.Drawing.Size(90, 26);
            this.write.TabIndex = 4;
            this.write.Text = "Write";
            this.write.UseVisualStyleBackColor = true;
            this.write.Click += new System.EventHandler(this.write_Click);
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(468, 575);
            this.Controls.Add(this.groupBox4);
            this.Controls.Add(this.groupBox3);
            this.Controls.Add(this.write);
            this.Controls.Add(this.groupBox1);
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

        private System.Windows.Forms.Button connect;
        private System.Windows.Forms.ComboBox comboBox1;
        private System.Windows.Forms.TextBox wifiPass;
        private System.Windows.Forms.GroupBox groupBox2;
        private System.Windows.Forms.GroupBox groupBox3;
        private System.Windows.Forms.ListView listView1;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private System.Windows.Forms.ColumnHeader columnHeader3;
        private System.Windows.Forms.Button refresh;
        private System.Windows.Forms.GroupBox groupBox1;
        private System.Windows.Forms.TextBox userNm;
        private System.Windows.Forms.GroupBox groupBox4;
        private System.Windows.Forms.TextBox userPs;
        private System.Windows.Forms.Button write;
    }
}

