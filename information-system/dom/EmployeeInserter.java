import javax.xml.parsers.*;
import javax.xml.transform.*;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import org.xml.sax.SAXException;  
import java.io.*;
import org.w3c.dom.*;

public class EmployeeInserter {

	static String file = "employees.xml";

	public static void main(String[] args){
		args = new String[3];
		args[0] = "A";
		args[1] = "B";
		args[2] = "10";
		if (args.length != 3) {
			System.out.println("Usage: java EmployeeInserter <firstName> <lastName> <workingHours>");
			System.exit(0);
		}

		String firstName = args[0];
		String lastName = args[1];
		String workingHours = args[2];

		DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
		try {
			DocumentBuilder builder = factory.newDocumentBuilder();
			Document doc = builder.parse( new File( file ) );

			Element rootElement = doc.getDocumentElement();
			Element newEmployee = createNewEmployee(doc, firstName, lastName, workingHours);

			rootElement.appendChild(newEmployee);

			System.out.println(prettyPrintXML(doc));
		}
		catch(ParserConfigurationException pce) {
			System.out.println(pce.getMessage());
		}
		catch(SAXException se) {
			System.out.println(se.getMessage());
		}
		catch(IOException ioe) {
			System.out.println(ioe.getMessage());
		}
	}

	public static Element createNewEmployee( Document doc, String firstName, 
			String lastName, String workingHours ) {

		Element newEmployee = doc.createElement("employee");
		Element fn = doc.createElement("firstName");
		Element ln = doc.createElement("lastName");
		Element wh = doc.createElement("workingHours");
		
		fn.setTextContent(firstName);
		ln.setTextContent(lastName);
		wh.setTextContent(workingHours);
		
		newEmployee.appendChild(fn);		
		newEmployee.appendChild(ln);		
		newEmployee.appendChild(wh);
		
		return newEmployee;
	}


	public static String prettyPrintXML(Node node) {
		TransformerFactory tfactory = TransformerFactory.newInstance();
		Transformer serializer;
		try {
			serializer = tfactory.newTransformer();
			serializer.setOutputProperty(OutputKeys.INDENT, "yes");
			serializer.setOutputProperty("{http://xml.apache.org/xslt}indent-amount", "2");

			StringWriter output = new StringWriter();
			serializer.transform(new DOMSource(node), new StreamResult(output));
			return output.toString();
		} catch (TransformerException e) {
			// this is fatal, just dump the stack and throw a runtime exception
			e.printStackTrace();
			throw new RuntimeException(e);
		}
	}
}