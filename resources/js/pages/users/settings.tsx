import { type ComponentProps } from "react";

import { Tabs } from "@narsil-cms/blocks";
import {
  ConfigurationForm,
  ProfileForm,
  SecurityForm,
} from "@narsil-cms/blocks/forms";
import { useLocalization } from "@narsil-cms/components/localization";
import { useAuth } from "@narsil-cms/hooks/use-props";
import type { FormType } from "@narsil-cms/types";

type UserSettingsProps = {
  profileForm: FormType;
  twoFactorForm: FormType;
  updatePasswordForm: FormType;
  userConfigurationForm: FormType;
};

function UserSettings({
  profileForm,
  twoFactorForm,
  updatePasswordForm,
  userConfigurationForm,
}: UserSettingsProps) {
  const { trans } = useLocalization();

  const auth = useAuth();

  return (
    <Tabs
      defaultValue={auth ? "account" : "configuration"}
      orientation="vertical"
      elements={
        [
          auth && {
            id: "account",
            title: trans("ui.account"),
            icon: "user-edit",
            content: (
              <ProfileForm
                profileForm={profileForm}
                updatePasswordForm={updatePasswordForm}
              />
            ),
          },
          {
            id: "configuration",
            title: trans("ui.personalization"),
            icon: "settings",
            content: <ConfigurationForm form={userConfigurationForm} />,
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
