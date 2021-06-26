package controller;

import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.geometry.Insets;
import javafx.scene.control.Button;
import javafx.scene.control.ContentDisplay;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableView;
import javafx.scene.layout.StackPane;
import javafx.stage.Stage;
import persistence.Project;

public class ShowProjectCell extends TableCell<Project, Boolean> {

    private final Button showBtn = new Button("Voir");
    private final StackPane paddedBtn = new StackPane();


    /**
     * AddPersonCell constructor
     * @param stage the stage in which the table is placed.
     * @param table the table where to place the button.
     */
    public ShowProjectCell(Stage stage, TableView<Project> table) {

        paddedBtn.setPadding(new Insets(3));
        paddedBtn.getChildren().add(showBtn);

        showBtn.setOnAction(event -> {
            Project project = table.getItems().get(ShowProjectCell.this.getIndex());
            ControllerOne.goToProjectIndex(event, project);
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
