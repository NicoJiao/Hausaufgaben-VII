import javax.xml.parsers.SAXParserFactory;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.ParserConfigurationException;
import org.xml.sax.SAXException;
import org.xml.sax.XMLReader;
import org.xml.sax.InputSource;
import java.io.IOException;
import java.io.FileNotFoundException;


public class WorkingHoursCheckerMain {


  public static void main(String[] args){
//    if (args.length != 1) {
//                System.out.println("Usage: java WorkingHoursCheckerMain <xmlFile>");
//                System.exit(0);
//    }
    try {
                SAXParserFactory spf = SAXParserFactory.newInstance();
                spf.setNamespaceAware(true);

		XMLReader xmlReader = spf.newSAXParser().getXMLReader();
		xmlReader.setContentHandler(new WorkingHoursChecker());
		xmlReader.parse(new InputSource("employees.xml"));

        } catch (ParserConfigurationException pce) {
                System.out.println(pce.getMessage());
        } catch (SAXException se) {
                System.out.println(se.getMessage());
        } catch (FileNotFoundException fnfe) {
                System.out.println(fnfe.getMessage());
        } catch (IOException ioe) {
                System.out.println(ioe.getMessage());
        }


  }
}