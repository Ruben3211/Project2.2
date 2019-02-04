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

            stringsel.remove(stringsel.size() - 1);
            for(String insertString : stringsel){
                
                System.out.println(stringsel.size());

                String reqString = insertString.substring(insertString.indexOf("<STN>") + 5 ,insertString.indexOf("</STN>"));
                //System.out.println(reqString);

                if (MultiThreadedServer.checkarray(reqString)) {
                    //System.out.println(stringsel[m]);


                    MultiThreadedServer.bufferForFile.add(insertString);
                    //System.out.println(MultiThreadedServer.bufferForFile.size());

                    //MultiThreadedServer.fillarray(bufferForFile,stringsel[m]);
                    if(MultiThreadedServer.bufferForFile.size() > 170 ) {
                        String multiToString = MultiThreadedServer.bufferForFile.toString();
                        //System.out.println(multiToString);

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


                        bos = new BufferedOutputStream(new FileOutputStream(newfile));
                        bos.write(multiToString.getBytes(), 0, multiToString.length());
                        bos.close();
                        System.out.println("Cleared array list");
                        deleteArray();
                        // /MultiThreadedServer.bufferForFile.clear();

                    }
                }
            }

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