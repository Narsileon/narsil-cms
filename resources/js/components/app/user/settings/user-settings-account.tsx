import { TabsContent } from "@/components/ui/tabs";
import { useRoute } from "ziggy-js";
import { useTranslationsStore } from "@/stores/translations-store";
import {
  Section,
  SectionContent,
  SectionHeader,
  SectionTitle,
} from "@/components/ui/section";

function UserSettingsAccount() {
  const route = useRoute();

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
