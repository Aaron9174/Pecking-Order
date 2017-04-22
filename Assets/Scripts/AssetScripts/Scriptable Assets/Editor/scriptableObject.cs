﻿using UnityEngine;
using UnityEditor;

public static class scriptableObject {
    public static void CreateAsset<T>() where T: ScriptableObject
    {
        var asset = ScriptableObject.CreateInstance<T>();
        ProjectWindowUtil.CreateAsset(asset, "New " + typeof(T).Name + ".asset");
    }
}