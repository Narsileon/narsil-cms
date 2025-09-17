import { Button, Heading, Separator } from "@narsil-cms/blocks";
import {
  FormFieldRenderer,
  FormProvider,
  FormRoot,
} from "@narsil-cms/components/form";
import { useLabels } from "@narsil-cms/components/labels";
import {
  SectionContent,
  SectionHeader,
  SectionRoot,
} from "@narsil-cms/components/section";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { type FormType } from "@narsil-cms/types";

type ProfileFormProps = {
  profileForm: FormType;
  updatePasswordForm: FormType;
};

function ProfileForm({ profileForm, updatePasswordForm }: ProfileFormProps) {
  const { trans } = useLabels();

  const auth = useAuth();

  return (
    <>
      <FormProvider
        id={profileForm.id}
        action={profileForm.action}
        elements={profileForm.form}
        method={profileForm.method}
        initialValues={{
          avatar: auth?.avatar,
          first_name: auth?.first_name,
          last_name: auth?.last_name,
        }}
        render={() => (
          <SectionRoot>
            <SectionHeader className="border-b">
              <Heading level="h2">{trans("ui.account")}</Heading>
              <Button
                form={profileForm.id}
                icon={profileForm.submitIcon}
                type="submit"
              >
                {profileForm.submitLabel}
              </Button>
            </SectionHeader>
            <SectionContent>
              <FormRoot className="grid-cols-12 gap-4">
                {profileForm.form.map((element, index) => (
                  <FormFieldRenderer element={element} key={index} />
                ))}
              </FormRoot>
            </SectionContent>
          </SectionRoot>
        )}
      />
      <Separator />
      <FormProvider
        id={updatePasswordForm.id}
        action={updatePasswordForm.action}
        elements={updatePasswordForm.form}
        method={updatePasswordForm.method}
        render={({ reset, setDefaults }) => (
          <SectionRoot>
            <SectionHeader className="border-b">
              <Heading level="h2">{trans("ui.password")}</Heading>
              <Button
                form={updatePasswordForm.id}
                icon={updatePasswordForm.submitIcon}
                type="submit"
              >
                {updatePasswordForm.submitLabel}
              </Button>
            </SectionHeader>
            <SectionContent>
              <FormRoot
                className="grid-cols-12 gap-4"
                options={{
                  onSuccess: () => {
                    reset?.();
                    setDefaults?.();
                  },
                }}
              >
                {updatePasswordForm.form.map((element, index) => (
                  <FormFieldRenderer element={element} key={index} />
                ))}
              </FormRoot>
            </SectionContent>
          </SectionRoot>
        )}
      />
    </>
  );
}

export default ProfileForm;
