import { Card, CardContent } from "@/components/ui/card";
import { FormProvider, Form, FormSubmit } from "@/components/ui/form";
import { useModalStore } from "@/stores/modal-store";
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

type FormProps = { _modal: boolean; data: any; form: LaravelForm };

function ResourceForm({ _modal = false, data, form }: FormProps) {
  const { closeTopModal } = useModalStore();

  return (
    <ResizablePanelGroup autoSaveId="resource-form" direction="horizontal">
      <ResizablePanel collapsible={true} defaultSize={80} minSize={40}>
        <Section className="p-4">
          <SectionHeader>
            <SectionTitle level="h1" variant="h4">
              {getLabel(form.labels, "title")}
            </SectionTitle>
          </SectionHeader>
          <SectionContent>
            <FormProvider
              id={form.id}
              inputs={form.inputs}
              initialValues={{
                _back: _modal,
                ...data,
              }}
              render={() => (
                <Form
                  method={form.method}
                  url={form.action}
                  options={{
                    onSuccess: () => {
                      if (_modal) {
                        closeTopModal();
                      }
                    },
                  }}
                >
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
