using UnityEditor;

public class characterIntegration
{
    [MenuItem("Assets/Create/characterAsset")]
    public static void CreateScriptableObject()
    {
        scriptableObject.CreateAsset<characterAsset>();
    }
}
