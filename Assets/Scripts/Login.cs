using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
using System.Collections;
using System;
using System.Text.RegularExpressions;

public class Login : MonoBehaviour {
	public GameObject username;
	public GameObject password;
	private string Username;
	private string Password;

	public void LoginButton(){
        string loginURL = "http://test1.xu4qu3w2zy.us-east-1.elasticbeanstalk.com/";
        WWWForm form = new WWWForm();
        form.AddField("login","true");


        if (Username != ""){
            Debug.Log(Username);
            form.AddField("username", Username);
        } else {
			Debug.LogWarning("Username Field Empty");
		}
        if (Password != "") {
            Debug.Log(Password);
            form.AddField("password", Password);
        }
		 else {
			Debug.LogWarning("Password Field Empty");
		}
        WWW w = new WWW(loginURL, form);
        while (!w.isDone) { }
        string result = w.text;
        Debug.Log(result);
        if (result=="true")
        {
            username.GetComponent<InputField>().text = "";
            password.GetComponent<InputField>().text = "";
            print("Login Sucessful");
            //go to the main menu
            SceneManager.LoadScene("Main Menu");
        }
	}

    // Update is called once per frame
    void Update () {
		if (Input.GetKeyDown(KeyCode.Tab)){
			if (username.GetComponent<InputField>().isFocused){
				password.GetComponent<InputField>().Select();
			}
		}
		if (Input.GetKeyDown(KeyCode.Return)){
			if (Password != ""&&Password != ""){
				LoginButton();
			}
		}
		Username = username.GetComponent<InputField>().text;
		Password = password.GetComponent<InputField>().text;	
	}
}
