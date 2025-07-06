import { Card, CardContent } from "@/components/ui/card";
import { FormProvider, Form, FormSubmit } from "@/components/ui/form";
import FormInputBlock from "@/blocks/form-input-block";
import {
  ResizableHandle,
  ResizablePanel,
  ResizablePanelGroup,
} from "@/components/ui/resizable";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelForm } from "@/types/global";

type FormProps = { form: LaravelForm };

function ResourceForm({ form }: FormProps) {
  return (
    <ResizablePanelGroup autoSaveId="resource-form" direction="horizontal">
      <ResizablePanel collapsible={true} defaultSize={80} minSize={40}>
        <Section className="p-4">
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {form.title}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <FormProvider
              id="login-form"
              initialData={{
                email: "",
                password: "",
                remember: false,
              }}
              render={() => (
                <Form method={form.method} url={form.action}>
                  {form.inputs.map((input, index) => (
                    <FormInputBlock {...input} key={index} />
                  ))}
                  <FormSubmit>{form.submit}</FormSubmit>
                </Form>
              )}
            />
          </SectionContent>
        </Section>
      </ResizablePanel>
      <ResizableHandle withHandle={true} />
      <ResizablePanel collapsible={true} defaultSize={20} minSize={10}>
        <div className="grid gap-4 p-4">
          <Card>
            <CardContent></CardContent>
          </Card>
          <Card>
            <CardContent></CardContent>
          </Card>
        </div>
      </ResizablePanel>
    </ResizablePanelGroup>
  );
}

export default ResourceForm;
