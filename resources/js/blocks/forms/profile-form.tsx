import { useAuth } from "@narsil-cms/hooks/use-props";
import { Button } from "@narsil-ui/components/button";
import { FormElement, FormProvider, FormRoot, registry } from "@narsil-ui/components/form";
import { Heading } from "@narsil-ui/components/heading";
import { Icon } from "@narsil-ui/components/icon";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { Separator } from "@narsil-ui/components/separator";
import { useTranslator } from "@narsil-ui/components/translator";
import type { FormData } from "@narsil-ui/types";
import { Fragment } from "react";

type ProfileFormProps = {
  profileForm: FormData;
  updatePasswordForm: FormData;
};

function ProfileForm({ profileForm, updatePasswordForm }: ProfileFormProps) {
  const { trans } = useTranslator();

  const auth = useAuth();

  return (
    <>
      <FormProvider
        id={profileForm.id}
        action={profileForm.action}
        steps={profileForm.steps}
        method={profileForm.method}
        initialData={{
          avatar: auth?.avatar,
          first_name: auth?.first_name,
          last_name: auth?.last_name,
        }}
        render={() => {
          return (
            <SectionRoot>
              <SectionHeader className="border-b">
                <Heading level="h2">{trans("ui.account")}</Heading>
                <Button form={profileForm.id} type="submit">
                  {profileForm.submitIcon && <Icon name={profileForm.submitIcon} />}
                  {profileForm.submitLabel}
                </Button>
              </SectionHeader>
              <SectionContent>
                <FormRoot className="grid-cols-12 gap-4">
                  {profileForm.steps.map((step, index) => {
                    return (
                      <Fragment key={index}>
                        {step.elements?.map((element, index) => {
                          return <FormElement {...element} registry={registry} key={index} />;
                        })}
                      </Fragment>
                    );
                  })}
                </FormRoot>
              </SectionContent>
            </SectionRoot>
          );
        }}
      />
      <Separator />
      <FormProvider
        id={updatePasswordForm.id}
        action={updatePasswordForm.action}
        steps={updatePasswordForm.steps}
        method={updatePasswordForm.method}
        render={({ reset, setDefaults }) => {
          return (
            <SectionRoot>
              <SectionHeader className="border-b">
                <Heading level="h2">{trans("ui.password")}</Heading>
                <Button form={updatePasswordForm.id} type="submit">
                  {updatePasswordForm.submitIcon && <Icon name={updatePasswordForm.submitIcon} />}
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
                  {updatePasswordForm.steps.map((step, index) => {
                    return (
                      <Fragment key={index}>
                        {step.elements?.map((element, index) => {
                          return <FormElement {...element} registry={registry} key={index} />;
                        })}
                      </Fragment>
                    );
                  })}
                </FormRoot>
              </SectionContent>
            </SectionRoot>
          );
        }}
      />
    </>
  );
}

export default ProfileForm;
