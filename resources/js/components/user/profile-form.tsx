import { Form, FormProvider, FormSubmit } from "@narsil-cms/components/ui/form";
import { Separator } from "@narsil-cms/components/ui/separator";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { useLabels } from "@narsil-cms/components/ui/labels";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@narsil-cms/components/ui/section";
import type { FormType } from "@narsil-cms/types/forms";

type ProfileFormProps = {
  profileForm: FormType;
  updatePasswordForm: FormType;
};

function ProfileForm({ profileForm, updatePasswordForm }: ProfileFormProps) {
  const { getLabel } = useLabels();

  const auth = useAuth();

  return (
    <>
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">{getLabel("ui.account")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          <FormProvider
            id={profileForm.id}
            fields={profileForm.fields}
            initialValues={{
              first_name: auth?.first_name,
              last_name: auth?.last_name,
            }}
            render={() => (
              <Form
                className="gap-6 md:grid-cols-2"
                method={profileForm.method}
                url={profileForm.url}
              >
                {profileForm.content.map((input, index) => (
                  <FormInputBlock {...input} key={index} />
                ))}
                <FormSubmit>{profileForm.submit}</FormSubmit>
              </Form>
            )}
          />
        </SectionContent>
      </Section>
      <Separator />
      <Section>
        <SectionHeader className="border-b">
          <SectionTitle level="h2">{getLabel("ui.password")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          <FormProvider
            id={updatePasswordForm.id}
            fields={updatePasswordForm.content}
            render={() => (
              <Form
                className="gap-6 md:grid-cols-2"
                method={updatePasswordForm.method}
                url={updatePasswordForm.url}
              >
                {updatePasswordForm.content.map((input, index) => (
                  <FormInputBlock {...input} key={index} />
                ))}
                <FormSubmit>{updatePasswordForm.submit}</FormSubmit>
              </Form>
            )}
          />
        </SectionContent>
      </Section>
    </>
  );
}

export default ProfileForm;
