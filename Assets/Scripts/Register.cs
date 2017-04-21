using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
using System.Collections;
using System;
using System.Text.RegularExpressions;

public class Register : MonoBehaviour {
	public GameObject username;
	public GameObject password;
	public GameObject confPassword;
    public GameObject usernameTaken;
    public GameObject RegSuccess;
    public GameObject RegFail;
    private string Username;
	private string Password;
	private string ConfPassword;
	private string form;
	
	public void RegisterButton(){
		bool CPW = false;

        string loginURL = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/";
        WWWForm form = new WWWForm();
        form.AddField("register", "true");

        if (Username != "")
        {
            Debug.Log(Username);
            form.AddField("username", Username);
        }
        else
        {
			Debug.LogWarning("Username field Empty");
		}
		if (Password != "")
        {
            Debug.Log(Password);
            form.AddField("password", Password);
        }
        else
        {
			Debug.LogWarning("Password Field Empty");
		}
		if (ConfPassword != ""){
			if (ConfPassword == Password){
				CPW = true;
                Debug.Log("the passwords match");
            } else {
				Debug.LogWarning("Passwords Don't Match");
			}
		} else {
			Debug.LogWarning("Confirm Password Field Empty");
		}
		if (CPW == true){
            //waiting for the thing to return 
            WWW download = new WWW(loginURL, form);
            while (!download.isDone) {}
            string result = download.text;
            Debug.Log(result);
            if (result=="taken")
            {
                Debug.Log("username taken");
                usernameTaken.SetActive(true);
                username.GetComponent<InputField>().text = "";
                password.GetComponent<InputField>().text = "";
                confPassword.GetComponent<InputField>().text = "";
            }
            else if(result=="success")
            {
                WWWForm forminit = new WWWForm();
                forminit.AddField("initCollection", "true");
                forminit.AddField("username", Username);
                string initURL = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/deckBuilder.php";
                WWW winit = new WWW(initURL, forminit);
                //while (!winit.isDone) { }
                //string resultInit = winit.text;
                Debug.Log("registerd");
                RegSuccess.SetActive(true);
                username.GetComponent<InputField>().text = "";
                password.GetComponent<InputField>().text = "";
                confPassword.GetComponent<InputField>().text = "";
            }
            else
            {
                Debug.Log("server error");
                RegFail.SetActive(true);
                username.GetComponent<InputField>().text = "";
                password.GetComponent<InputField>().text = "";
                confPassword.GetComponent<InputField>().text = "";
            }
			
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
