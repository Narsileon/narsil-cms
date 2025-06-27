import { Button } from "@/components/ui/button";
import { GlobalProps } from "@/types/global";
import { Input } from "@/components/ui/input";
import { route } from "ziggy-js";
import { TabsContent } from "@/components/ui/tabs";
import { usePage } from "@inertiajs/react";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Form,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";

import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";
import { Separator } from "@/components/ui/separator";

function UserSettingsAccount() {
  const { trans } = useTranslationsStore();

  const { first_name, last_name } = usePage<GlobalProps>().props.auth;

  return (
    <TabsContent value="account">
      <Section>
        <SectionHeader>
          <SectionTitle level="h2">{trans("ui.account")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          <Form
            id="profile"
            className="grid gap-6"
            method="put"
            url={route("user-profile-information.update")}
            attributes={{
              first_name: first_name,
              last_name: last_name,
            }}
          >
            <FormField
              name="last_name"
              render={({ onChange, ...field }) => (
                <FormItem>
                  <FormLabel required={true} />
                  <Input
                    autoComplete="family-name"
                    onChange={(e) => onChange(e.target.value)}
                    {...field}
                  />
                  <FormMessage />
                </FormItem>
              )}
            />
            <FormField
              name="first_name"
              render={({ onChange, ...field }) => (
                <FormItem>
                  <FormLabel required={true} />
                  <Input
                    autoComplete="given-name"
                    onChange={(e) => onChange(e.target.value)}
                    {...field}
                  />
                  <FormMessage />
                </FormItem>
              )}
            />

            <Button form="profile" type="submit">
              {trans("ui.update")}
            </Button>
          </Form>
        </SectionContent>
      </Section>
      <Separator />
      <Section>
        <SectionHeader>
          <SectionTitle level="h2">{trans("ui.password")}</SectionTitle>
        </SectionHeader>
        <SectionContent>
          <Form
            id="password"
            className="grid gap-6"
            method="put"
            url={route("user-password.update")}
            attributes={{
              first_name: first_name,
              last_name: last_name,
            }}
          >
            <FormField
              name="current_password"
              render={({ onChange, ...field }) => (
                <FormItem>
                  <FormLabel required={true} />
                  <Input
                    autoComplete="current-password"
                    type="password"
                    onChange={(e) => onChange(e.target.value)}
                    {...field}
                  />
                  <FormMessage />
                </FormItem>
              )}
            />
            <FormField
              name="password"
              render={({ onChange, ...field }) => (
                <FormItem>
                  <FormLabel required={true} />
                  <Input
                    autoComplete="new-password"
                    type="password"
                    onChange={(e) => onChange(e.target.value)}
                    {...field}
                  />
                  <FormMessage />
                </FormItem>
              )}
            />
            <FormField
              name="password_confirmation"
              render={({ onChange, ...field }) => (
                <FormItem>
                  <FormLabel required={true} />
                  <Input
                    autoComplete="new-password"
                    type="password"
                    onChange={(e) => onChange(e.target.value)}
                    {...field}
                  />
                  <FormMessage />
                </FormItem>
              )}
            />
            <Button form="password" type="submit">
              {trans("ui.update")}
            </Button>
          </Form>
        </SectionContent>
      </Section>
    </TabsContent>
  );
}

export default UserSettingsAccount;
