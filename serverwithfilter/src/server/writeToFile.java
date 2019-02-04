package server;

import java.io.BufferedOutputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.Arrays;
import java.util.LinkedList;
import java.util.List;

public class writeToFile {

    public static synchronized void write(String newfile, String strFileContents, BufferedOutputStream bos){

        try {

            List<String> stringsel = new LinkedList<String>(Arrays.asList(strFileContents.split("(?<=</MEASUREMENT>)")));

//          Remove weatherdata tag from list
            stringsel.remove(stringsel.size() - 1);
            for(String insertString : stringsel){

            if(insertString.contains("<STN>") && insertString.contains("<MEASUREMENT>") && insertString.contains("</MEASUREMENT>")) {
                //System.out.println(stringsel.size());
                    String reqString = insertString.substring(insertString.indexOf("<STN>") + 5, insertString.indexOf("</STN>"));

                if (MultiThreadedServer.checkarray(reqString)) {


                    MultiThreadedServer.bufferForFile.add(insertString);


                    if(MultiThreadedServer.bufferForFile.size() > 170 ) {
                        String multiToString = MultiThreadedServer.bufferForFile.toString();

//                      Strip string to generate a good XML file
                        multiToString = multiToString.replace(",", "");  //remove the commas
                        multiToString = multiToString.replace("[", ""); //remove the right bracket
                        multiToString = multiToString.replace("]", "");  //remove the left bracket
                        multiToString = multiToString.replace("<?xml version=\"1.0\"?>", "");  //remove the random xml tags
                        multiToString = multiToString.replace("<WEATHERDATA>", "");  //remove the random xml tags
                        multiToString = multiToString.replace("</WEATHERDATA>", "");  //remove the random xml tags
                        multiToString = multiToString.trim();           //remove trailing spaces from partially initialized arrays

//                      Redo the XML tags but now in the correct places
                        multiToString = "<WEATHERDATA>" + "\n" + "\t" + multiToString;
                        multiToString = "<?xml version=\"1.0\"?>" + "\n" + multiToString;
                        multiToString = multiToString + "\n" + "</WEATHERDATA>" ;


                        bos = new BufferedOutputStream(new FileOutputStream(newfile),65536 );
                        bos.write(multiToString.getBytes(), 0, multiToString.length());
                        bos.close();
                        System.out.println("Cleared array list");
                        deleteArray();

                    }}
                }
            }
            stringsel.clear();
        } catch (IOException e) {
            //report exception somewhere.
            e.printStackTrace();
        }


//                END FILTER CODE
    }

    private static synchronized void deleteArray(){
        MultiThreadedServer.bufferForFile.clear();
    }

}