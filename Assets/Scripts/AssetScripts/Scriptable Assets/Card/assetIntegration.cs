using UnityEngine;
using UnityEditor;

public class assetIntegration
{
    [MenuItem("Assets/Create/cardAsset")]
    public static void CreateYourScriptableObject()
    {
        scriptableObject.CreateAsset<cardAsset>();
    }
}
