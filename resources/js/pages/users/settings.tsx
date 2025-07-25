import { ScrollArea } from "@narsil-cms/components/ui/scroll-area";
import { Separator } from "@narsil-cms/components/ui/separator";
import { SettingsIcon, ShieldCheckIcon, UserPenIcon } from "lucide-react";
import {
  TabsList,
  Tabs,
  TabsTrigger,
  TabsContent,
} from "@narsil-cms/components/ui/tabs";
import { useAuth } from "@narsil-cms/hooks/use-props";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { useMinMd } from "@narsil-cms/hooks/use-breakpoints";
import ConfigurationForm from "@narsil-cms/components/app/user/configuration-form";
import ProfileForm from "@narsil-cms/components/app/user/profile-form";
import SecurityForm from "@narsil-cms/components/app/user/security-form";
import type { LaravelForm } from "@narsil-cms/types/types";

type UserSettingsProps = {
  profileForm: LaravelForm;
  twoFactorForm: LaravelForm;
  updatePasswordForm: LaravelForm;
  userConfigurationForm: LaravelForm;
};

function UserSettings({
  profileForm,
  twoFactorForm,
  updatePasswordForm,
  userConfigurationForm,
}: UserSettingsProps) {
  const { getLabel } = useLabels();

  const auth = useAuth();
  const minMd = useMinMd();

  return (
    <Tabs
      className="h-full overflow-hidden"
      defaultValue={auth ? "account" : "configuration"}
      orientation="vertical"
    >
      <TabsList className="md:border-r">
        {auth ? (
          <TabsTrigger value="account">
            <UserPenIcon />
            {getLabel("ui.account")}
          </TabsTrigger>
        ) : null}
        <TabsTrigger value="configuration">
          <SettingsIcon />
          {getLabel("ui.personalization")}
        </TabsTrigger>
        {auth ? (
          <TabsTrigger value="security">
            <ShieldCheckIcon />
            {getLabel("ui.security")}
          </TabsTrigger>
        ) : null}
      </TabsList>
      <Separator orientation={minMd ? "vertical" : "horizontal"} />
      <ScrollArea className="h-full w-full">
        {auth ? (
          <TabsContent value="account">
            <ProfileForm
              profileForm={profileForm}
              updatePasswordForm={updatePasswordForm}
            />
          </TabsContent>
        ) : null}

        <TabsContent value="configuration">
          <ConfigurationForm form={userConfigurationForm} />
        </TabsContent>
        {auth ? (
          <TabsContent value="security">
            <SecurityForm twoFactorForm={twoFactorForm} />
          </TabsContent>
        ) : null}
      </ScrollArea>
    </Tabs>
  );
}

export default UserSettings;
