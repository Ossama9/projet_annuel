package controller;

import javafx.geometry.Insets;
import javafx.scene.control.Button;
import javafx.scene.control.ContentDisplay;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableView;
import javafx.scene.layout.StackPane;
import javafx.stage.Stage;
import persistence.Asso;
import persistence.User;

public class ShowAssoCell extends TableCell<Asso, Boolean> {

    private final Button showBtn = new Button("Voir");
    private final StackPane paddedBtn = new StackPane();


    /**
     * ShowAssoCell constructor
     * @param stage the stage in which the table is placed.
     * @param table the table where to place the button.
     */

    public ShowAssoCell(Stage stage, TableView<Asso> table, User user) {

        paddedBtn.setPadding(new Insets(3));
        paddedBtn.getChildren().add(showBtn);

        showBtn.setOnAction(event -> {
            Asso asso = table.getItems().get(ShowAssoCell.this.getIndex());
            ControllerOne.loadAdminAsso(event, asso, user);
        });
    }

    /** Place the button only if the rows is not empty. */
    @Override
    protected void updateItem(Boolean item, boolean empty) {
        super.updateItem(item, empty);
        if (!empty) {
            setContentDisplay(ContentDisplay.GRAPHIC_ONLY);
            setGraphic(showBtn);
        } else {
            setGraphic(null);
        }
    }
}
