using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using System;
using System.Text.RegularExpressions;

public class Register : MonoBehaviour {
	public GameObject username;
	public GameObject password;
	public GameObject confPassword;
	private string Username;
	private string Password;
	private string ConfPassword;
	private string form;
	private string[] Characters = {"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
								   "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
								   "1","2","3","4","5","6","7","8","9","0","_","-"};
	
	public void RegisterButton(){
		bool UN = false;
		bool EM = false;
		bool PW = false;
		bool CPW = false;

        /*string loginURL = "http://test1.xu4qu3w2zy.us-east-1.elasticbeanstalk.com/";
        WWWForm form = new WWWForm();
        form.AddField("register", "true");
        form.AddField("username", Username);
        form.AddField("password", Password);

        /*WWW download = new WWW(loginURL, form);
        yield return download;*/

        if (Username != "")
        {
            //check if username is already taken here, if yes warning, if not continue on
			if (!System.IO.File.Exists(@"E:/UnityTestFolder/"+Username+".txt"))
            {
				UN = true;
			}
            else
            {
				Debug.LogWarning("Username Taken");
			}
		}
        else
        {
			Debug.LogWarning("Username field Empty");
		}
		if (Password != ""){
			if(Password.Length > 5){
				PW = true;
			} else {
				Debug.LogWarning("Password Must Be atleast 6 Characters long");
			}
		} else {
			Debug.LogWarning("Password Field Empty");
		}
		if (ConfPassword != ""){
			if (ConfPassword == Password){
				CPW = true;
			} else {
				Debug.LogWarning("Passwords Don't Match");
			}
		} else {
			Debug.LogWarning("Confirm Password Field Empty");
		}
		if (UN == true&&EM == true&&PW == true&&CPW == true){
			bool Clear = true;
			int i = 1;
			foreach(char c in Password){
				if (Clear){
					Password = "";
					Clear = false;
				}
				i++;
				char Encrypted = (char)(c * i);
				Password += Encrypted.ToString();
			}
            //once it passes all this stuff the users information needs to be enterd into the database through a php script
			form = (Username+Environment.NewLine+Environment.NewLine+Password);
			System.IO.File.WriteAllText(@"E:/UnityTestFolder/"+Username+".txt", form);
			username.GetComponent<InputField>().text = "";
			password.GetComponent<InputField>().text = "";
			confPassword.GetComponent<InputField>().text = "";
			print ("Registration Complete");
		}

	}
	
	// Update is called once per frame
	void Update () {
		if (Input.GetKeyDown(KeyCode.Tab)){
            if (username.GetComponent<InputField>().isFocused){
                password.GetComponent<InputField>().Select();
            }
			if (password.GetComponent<InputField>().isFocused){
				confPassword.GetComponent<InputField>().Select();
			}
		}
		if (Input.GetKeyDown(KeyCode.Return)){
			if (Password != "" &&Password != ""&&ConfPassword != ""){
				RegisterButton();
			}
		}
		Username = username.GetComponent<InputField>().text;
		Password = password.GetComponent<InputField>().text;
		ConfPassword = confPassword.GetComponent<InputField>().text;
	}

}
