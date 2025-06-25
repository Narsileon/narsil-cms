import { TabsContent } from "@/components/ui/tabs";
import { route } from "ziggy-js";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

function UserSettingsAccount() {
  const { trans } = useTranslationsStore();

  return (
    <TabsContent value="account">
      <Section>
        <SectionHeader>
          <SectionTitle level="h2">{trans("ui.account")}</SectionTitle>
        </SectionHeader>
        <SectionContent>Content</SectionContent>
      </Section>
    </TabsContent>
  );
}

export default UserSettingsAccount;
