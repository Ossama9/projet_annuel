package controller.user;

import javafx.fxml.FXML;
import javafx.scene.text.Text;
import persistence.User;

public class UserIndexController{

    User user = new User();

    @FXML
    private Text totalCoinsField;

    public void initData(User user){
        this.user = user;

        totalCoinsField.setText(String.valueOf(user.getTotalCoins()));
    }
}
