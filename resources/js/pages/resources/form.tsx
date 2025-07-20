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
import type { LaravelForm } from "@/types";

type FormProps = {
  _modal: boolean;
  data: any;
  form: LaravelForm;
  title: string;
};

function ResourceForm({ _modal = false, data, form, title }: FormProps) {
  const { closeTopModal } = useModalStore();

  return (
    <FormProvider
      id={form.id}
      fields={[...form.content, ...form.sidebar]}
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
          <ResizablePanelGroup
            autoSaveId="resource-form"
            direction="horizontal"
          >
            <ResizablePanel collapsible={true} defaultSize={80} minSize={10}>
              <Section className="p-4">
                <SectionHeader>
                  <SectionTitle level="h1" variant="h4">
                    {title}
                  </SectionTitle>
                </SectionHeader>
                <SectionContent className="grid gap-6 md:grid-cols-2">
                  {form.content.map((input, index) => (
                    <FormInputBlock {...input} key={index} />
                  ))}
                  <FormSubmit>{form.submit}</FormSubmit>
                </SectionContent>
              </Section>
            </ResizablePanel>
            <ResizableHandle withHandle={true} />
            <ResizablePanel collapsible={true} defaultSize={20} minSize={10}>
              <div className="grid gap-4 p-4">
                <Card>
                  <CardContent className="grid gap-6">
                    {form.sidebar.map((input, index) => (
                      <FormInputBlock {...input} key={index} />
                    ))}
                  </CardContent>
                </Card>
                <Card>
                  <CardContent></CardContent>
                </Card>
              </div>
            </ResizablePanel>
          </ResizablePanelGroup>
        </Form>
      )}
    />
  );
}

export default ResourceForm;
