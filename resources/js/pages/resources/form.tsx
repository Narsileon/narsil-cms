import { Card, CardContent } from "@narsil-cms/components/ui/card";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import {
  FormProvider,
  Form,
  FormSubmit,
  FormFieldRenderer,
} from "@narsil-cms/components/ui/form";
import {
  ResizableHandle,
  ResizablePanel,
  ResizablePanelGroup,
} from "@narsil-cms/components/ui/resizable";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { FormType } from "@narsil-cms/types/forms";

type FormProps = {
  _modal: boolean;
  data: any;
  form: FormType;
  title: string;
};

function ResourceForm({ _modal = false, data, form, title }: FormProps) {
  const { closeTopModal } = useModalStore();

  const { dataFields, mainFields, sidebarFields } = form.fields.reduce(
    (acc, field) => {
      switch (field.handle) {
        case "data":
          acc.dataFields = field.fields;
          break;
        case "sidebar":
          acc.sidebarFields = field.fields;
          break;
        default:
          acc.mainFields.push(field);
          break;
      }
      return acc;
    },
    {
      dataFields: undefined as typeof form.fields | undefined,
      mainFields: [] as typeof form.fields,
      sidebarFields: undefined as typeof form.fields | undefined,
    },
  );

  return (
    <FormProvider
      id={form.id}
      fields={form.fields}
      initialValues={{
        _back: _modal,
        ...data,
      }}
      render={() => (
        <Form
          method={form.method}
          url={form.url}
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
                <SectionContent className="grid gap-6">
                  {mainFields.map((field, index) => {
                    return <FormFieldRenderer field={field} key={index} />;
                  })}
                  <FormSubmit>{form.submit}</FormSubmit>
                </SectionContent>
              </Section>
            </ResizablePanel>
            {sidebarFields?.length || (dataFields?.length && data?.id) ? (
              <>
                <ResizableHandle withHandle={true} />
                <ResizablePanel
                  collapsible={true}
                  defaultSize={20}
                  minSize={10}
                >
                  <div className="grid gap-4 p-4">
                    {sidebarFields?.length ? (
                      <Card>
                        <CardContent className="grid gap-6">
                          {sidebarFields.map((field, index) => {
                            return (
                              <FormFieldRenderer field={field} key={index} />
                            );
                          })}
                        </CardContent>
                      </Card>
                    ) : null}
                    {dataFields?.length && data?.id ? (
                      <Card>
                        <CardContent className="grid grid-cols-2 justify-between">
                          {dataFields.map((field, index) => {
                            return (
                              <FormFieldRenderer field={field} key={index} />
                            );
                          })}
                        </CardContent>
                      </Card>
                    ) : null}
                  </div>
                </ResizablePanel>
              </>
            ) : null}
          </ResizablePanelGroup>
        </Form>
      )}
    />
  );
}

export default ResourceForm;
