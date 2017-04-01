using UnityEngine;

public enum Territory
{
    Air, 
    Water, 
    Land
}

public class characterAsset : ScriptableObject
{
    [Header("Basic Information")]
    public Territory type;
    public string className;
    public int MaxHealth = 30;
    public string characterName;
    public Sprite AvatarImage;
    public Sprite characterPowerIcon;
    public Sprite AvatarBGImage;
    public Sprite characterBGImage;
    public Color32 AvatarBGTint;
    public Color32 characterPowerBGTint;
    public Color32 typeCardTint;
    public Color32 typeRibbonsTint;
}
