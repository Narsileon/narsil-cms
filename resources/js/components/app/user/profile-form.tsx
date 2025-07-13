import { Form, FormProvider, FormSubmit } from "@/components/ui/form";
import { Separator } from "@/components/ui/separator";
import { useLabels } from "@/components/ui/labels";
import FormInputBlock from "@/blocks/form-input-block";
import useAuth from "@/hooks/use-auth";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import type { LaravelForm } from "@/types/global";

type ProfileFormProps = {
  profileForm: LaravelForm;
  updatePasswordForm: LaravelForm;
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
            inputs={profileForm.inputs}
            initialValues={{
              first_name: auth?.first_name,
              last_name: auth?.last_name,
            }}
            render={() => (
              <Form method={profileForm.method} url={profileForm.action}>
                {profileForm.inputs.map((input, index) => (
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
            inputs={updatePasswordForm.inputs}
            render={() => (
              <Form
                method={updatePasswordForm.method}
                url={updatePasswordForm.action}
              >
                {updatePasswordForm.inputs.map((input, index) => (
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
