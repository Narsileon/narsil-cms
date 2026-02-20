import { ProfileForm, SecurityForm } from "@narsil-cms/blocks/forms";
import { Tabs } from "@narsil-cms/blocks/tabs";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import UserConfigurationForm from "@narsil-ui/blocks/form";
import { Heading } from "@narsil-ui/components/heading";
import { SectionContent, SectionHeader, SectionRoot } from "@narsil-ui/components/section";
import { useTranslator } from "@narsil-ui/components/translator";
import { FormData } from "@narsil-ui/types";
import { type ComponentProps } from "react";

type UserSettingsProps = {
  profileForm: FormData;
  twoFactorForm: FormData;
  updatePasswordForm: FormData;
  userConfigurationForm: FormData;
};

function UserSettings({
  profileForm,
  twoFactorForm,
  updatePasswordForm,
  userConfigurationForm,
}: UserSettingsProps) {
  const { reloadTopModal } = useModalStore();
  const { trans } = useTranslator();

  const auth = useAuth();

  return (
    <Tabs
      defaultValue={auth ? "account" : "configuration"}
      orientation="vertical"
      tabsListProps={{
        className: "px-4 md:p-0 border-b",
      }}
      elements={
        [
          auth && {
            id: "account",
            title: trans("ui.account"),
            icon: "user-edit",
            content: (
              <ProfileForm profileForm={profileForm} updatePasswordForm={updatePasswordForm} />
            ),
          },
          {
            id: "configuration",
            title: trans("ui.personalization"),
            icon: "settings",
            content: (
              <SectionRoot>
                <SectionHeader className="border-b">
                  <Heading level="h2">{trans("ui.personalization")}</Heading>
                </SectionHeader>
                <SectionContent>
                  <UserConfigurationForm form={userConfigurationForm} onSuccess={reloadTopModal} />
                </SectionContent>
              </SectionRoot>
            ),
          },
          auth && {
            id: "security",
            title: trans("ui.security"),
            icon: "shield",
            content: <SecurityForm twoFactorForm={twoFactorForm} />,
          },
        ].filter(Boolean) as ComponentProps<typeof Tabs>["elements"]
      }
    />
  );
}

export default UserSettings;
