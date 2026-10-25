export interface Call {
  id: number;
  call_id: Object;
  phone_number: Object;
  agent: string;
  duration: number;
  recording_url: string;
  has_called_before: boolean;
  is_spam: boolean;
  created_at: Object | null;
}