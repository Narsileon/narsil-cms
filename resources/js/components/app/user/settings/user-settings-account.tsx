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

            <Button type="submit">{trans("ui.update")}</Button>
          </Form>
        </SectionContent>
      </Section>
    </TabsContent>
  );
}

export default UserSettingsAccount;
