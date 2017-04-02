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
	private string[] Characters = {"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
								   "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
								   "1","2","3","4","5","6","7","8","9","0","_","-"};
	
	public void RegisterButton(){
		bool CPW = false;

        string loginURL = "http://test1.xu4qu3w2zy.us-east-1.elasticbeanstalk.com/";
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
    /*IEnumerator WaitForRequest(WWW download)
    {
        yield return download;

        if (download.error == null)
        {
            Debug.Log("WWW Ok!: " + download.text);
        }
        else
        {
            Debug.Log("WWW Error: " + download.error);
        }
    }*/

}
